<?php

namespace App\Context\Account\Infrastructure\Templating\Twig\Context\Email;

use InvalidArgumentException;
use Twig\Environment as Twig;

use function base64_encode;
use function file_get_contents;
use function pathinfo;

/**
 * Class EmailPreviewContext
 * @package App\Context\Account\Infrastructure\Templating\Twig\Context\Email
 */
final class EmailPreviewContext implements EmailContextInterface
{
    /**
     * @var Twig
     */
    private Twig $twig;

    /**
     * EmailPreviewContext constructor.
     * @param Twig $twig
     */
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @inheritdoc
     */
    public function image(string $image, ?string $contentType = null): string
    {
        $file = $this->twig->getLoader()->getSourceContext($image);

        if ($path = $file->getPath()) {
            $contentType = pathinfo($path, PATHINFO_EXTENSION);
            $content = file_get_contents($path);
        } else {
            if (null === $contentType) {
                throw new InvalidArgumentException('Variable "$contentType" must not be null.');
            }
            $content = $file->getCode();
        }

        return 'data:image/' . $contentType . ';base64,' . base64_encode($content);
    }
}
