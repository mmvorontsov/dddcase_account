<?php

namespace App\Context\Account\Infrastructure\Templating\Twig\Context\Email;

use Symfony\Component\Mime\Email;
use Twig\Environment as Twig;
use Twig\Error\LoaderError;

use function md5;

/**
 * Class EmailContext
 * @package App\Context\Account\Infrastructure\Templating\Twig\Context\Email
 */
final class EmailContext implements EmailContextInterface
{
    /**
     * @var Twig
     */
    private Twig $twig;

    /**
     * @var Email
     */
    private Email $email;

    /**
     * EmailContext constructor.
     * @param Twig $twig
     * @param Email $email
     */
    public function __construct(Twig $twig, Email $email)
    {
        $this->twig = $twig;
        $this->email = $email;
    }

    /**
     * @param string $image
     * @param string|null $contentType
     * @return string
     * @throws LoaderError
     */
    public function image(string $image, ?string $contentType = null): string
    {
        $file = $this->twig->getLoader()->getSourceContext($image);
        $cid = md5($image);

        if ($path = $file->getPath()) {
            $this->email->embedFromPath($path, $cid, $contentType);
        } else {
            $this->email->embed($file->getCode(), $cid, $contentType);
        }

        return 'cid:' . $cid;
    }
}
