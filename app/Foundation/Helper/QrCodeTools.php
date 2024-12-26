<?php

namespace App\Foundation\Helper;

use Illuminate\Support\Facades\Log;
use LaravelQRCode\Facades\QRCode;
use Throwable;

class QrCodeTools
{
    /**
     * reference the page of settings
     */

    /**
     * The content of the QR code.
     *
     * The content of the QR code.
     * @var $content
     */
    protected $content;

    /**
     * The pixel size
     *
     * Default is 4, the size value is the integer between 1 to 10
     * @var $size
     */
    protected $size;

    /**
     * The margin size
     *
     * Default is 3, the margin value is the integer between 1 to 10
     * @var $margin
     */
    protected $margin;

    /**
     * The Error correction level
     *
     * The error correction level default is L, the string between L: 7%, M: 15%, Q: 25%, H: 30%
     * @var $correctLevel;
     */
    protected $correctLevel;


    /**
     * Output file type
     *
     * The output file type default is png, the string between png, svg
     * @var $fileType
     */
    protected $fileType;

    /**
     * The QR code text type
     *
     * The QR code text type default is text, the string between text, url, sms, phone, email, meCard, vCard, wifi
     *
     * @var $textType
     */
    protected $textType;

    /**
     * The QR code image output path
     *
     * The QR code image output path, should be set with 'Storage::dist()' method
     *
     * @var $outputFile
     */
    protected $outputFile;

    public function __construct(mixed $content, int $size = 4, int $margin = 3, string $correctLevel = 'L', string $fileType = 'png', string $textType = 'text', ?string $outputFile = null)
    {
        $this->content = $content;
        $this->size = $size;
        $this->margin = $margin;
        $this->correctLevel = $correctLevel;
        $this->fileType = $fileType;
        $this->textType = $textType;
        $this->outputFile = $outputFile;
    }

    public function __get(string $name)
    {
        if ($name === '') {
            return null;
        }

        return $this->$name;
    }

    public function __set(string $name, $value): void
    {
        $this->$name = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->$name);
    }

    public function __unset(string $name): void
    {
        unset($this->$name);
    }

    /**
     * Generates a QR code
     *
     * @return mixed The QR code as binary data or null if an error occurred
     */
    public function generate(): mixed
    {
        try {
            $qrCode = QRCode::{$this->textType}($this->content)
                ->setSize($this->size)
                ->setMargin($this->margin)
                ->setErrorCorrectionLevel($this->correctLevel);

            if ($this->outputFile) {
                $qrCode->setOutputFile($this->outputFile);
            }

            return $qrCode->{$this->fileType}();
        } catch (Throwable $e) {
            Log::error('QrCodeTools generate failed', [
                'data' => [
                    'textType' => $this->textType,
                    'content' => $this->content,
                    'size' => $this->size,
                    'margin' => $this->margin,
                    'correctLevel' => $this->correctLevel,
                    'fileType' => $this->fileType,
                    'outputFile' => $this->outputFile,
                ],
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }
}
