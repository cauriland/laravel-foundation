<?php

declare(strict_types=1);

use CauriLand\Foundation\UserInterface\Support\QRCode;

it('should generate an SVG', function () {
    expect(QRCode::generate('cauri:CdVSe37niA3uFUPgCgMUH2tMsHF4LpLoiX'))->toBeString();
    expect(QRCode::generate('cauri:CdVSe37niA3uFUPgCgMUH2tMsHF4LpLoiX'))->toContain('<svg');
});
