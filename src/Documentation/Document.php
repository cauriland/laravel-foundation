<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Documentation;

use CauriLand\Foundation\Documentation\Concerns\CanBeShared;
use Closure;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\CommonMark\MarkdownConverterInterface;
use PHPHtmlParser\Dom;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Sushi\Sushi;

/**
 * @property string $name
 */
class Document extends Model
{
    use CanBeShared;
    use Sushi;

    public static function docsCategories(): array
    {
        return static::type('docs')
            ->get(['category'])
            ->unique('category')
            ->pluck('category')
            ->values()
            ->toArray();
    }

    public static function findBySlug(string $slug): self
    {
        return static::where('slug', $slug)->firstOrFail();
    }

    public function previous(): ?self
    {
        return $this->getNeighbour('previous', fn ($value) => $value - 1);
    }

    public function next(): ?self
    {
        return $this->getNeighbour('next', fn ($value) => $value + 1);
    }

    public function hasPrevious(): bool
    {
        return ! empty($this->previous()?->toArray());
    }

    public function hasNext(): bool
    {
        return ! empty($this->next()?->toArray());
    }

    public function url(): string
    {
        if ($this->type === 'tutorials') {
            return route('tutorial', $this->slug);
        }

        return route('documentation', $this->slug);
    }

    public function scopeSlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }

    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function scopeCategories(Builder $query, array $categories): Builder
    {
        return $query->whereIn('category', $categories);
    }

    public function scopeTerm(Builder $query, string $term): Builder
    {
        return $query->where(
            fn ($query) => $query->where('body', 'like', '%'.$term.'%')->whereNotNull('name')
        );
    }

    public function nameWithHighlight(string $term): string
    {
        return $this->attributeWithHighlight($this->name, $term);
    }

    public function bodyWithHighlight(string $term): string
    {
        return $this->attributeWithHighlight($this->body, $term);
    }

    public function getRows()
    {
        return Cache::rememberForever('documents.all', function () {
            $documents = $this->getDocumentsFromDisk('docs');

            if (! config('filesystems.disks.tutorials')) {
                return $documents;
            }

            return array_merge($documents, $this->getDocumentsFromDisk('tutorials'));
        });
    }

    protected function getDocumentsFromDisk(string $type): array
    {
        $storage   = Storage::disk($type);
        $documents = [];

        foreach ($storage->allFiles() as $file) {
            if (! str_ends_with($file, '.php')) {
                continue;
            }

            $body    = $storage->get($file);
            $content = YamlFrontMatter::parse($body);
            $slug    = $file === 'index.blade.php' ? 'index' : Str::replaceFirst('.md.blade.php', '', $file);

            $documents[] = [
                'id'         => md5($file),
                'type'       => $type,
                'name'       => $content->matter('title'),
                'number'     => $content->matter('number'),
                'slug'       => $slug,
                'body'       => $body,
                'updated_at' => DeriveGitCommitDate::execute($storage->path($file)),
            ];
        }

        return $documents;
    }

    protected function getNeighbour(string $direction, Closure $callback): ?self
    {
        $cacheKey = md5('documents.'.$this->slug.'.neighbour.'.$direction);

        return Cache::rememberForever($cacheKey, function () use ($callback) {
            $storage = Storage::disk($this->type);

            $path = 'index.md.blade.php';
            if ($storage->exists('/index.blade.php')) {
                $path = 'index.blade.php';
            }

            $matches = [];
            $dom     = new Dom();
            $dom->loadStr(app(ViewFactory::class)->file($storage->path($path))->render());

            foreach ($dom->find('a') as $link) {
                $matches[] = [
                    'name' => trim($link->innerText),
                    'link' => str_replace('/'.$this->type.'/', '', trim($link->getAttribute('href'))),
                ];
            }

            $matches = collect($matches)->unique('link')->values();

            $index = $matches->search(fn ($match) => Str::endsWith($match['link'], $this->slug));

            $callbackValue = $callback($index);

            if ($callbackValue < 0 || $callbackValue >= count($matches)) {
                return;
            }

            return static::query()
                ->where('type', $this->type)
                ->where('slug', $matches[$callback($index)]['link'])
                ->first();
        });
    }

    protected function attributeWithHighlight(string $value, string $term): string
    {
        // Remove spaces
        $value = trim($value);
        // Remove FrontMatter
        $value = YamlFrontMatter::parse($value)->body();
        // Convert to Markdown
        $value = app(MarkdownConverterInterface::class)->convertToHtml($value)->getContent();
        // Remove HTML
        $value = strip_tags(htmlspecialchars_decode($value));
        // Remove new lines
        $value = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", '', $value);
        // Limit length
        $value = Str::limit($value, 256);
        // Highlight
        $value = preg_replace("/\b([a-z]*${term}[a-z]*)\b/i", '<span class="bg-theme-warning-100">$1</span>', $value);

        return $value;
    }
}
