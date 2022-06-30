<?php

namespace App\Context\Account\Infrastructure\Serialization;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Mapping\Loader\LoaderChain;
use Symfony\Component\Serializer\Mapping\Loader\XmlFileLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeZoneNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializerInterface;

use function str_replace;

/**
 * Class SymfonySerializerFactory
 * @package App\Context\Account\Infrastructure\Serialization
 */
final class SymfonySerializerFactory
{
    /**
     * @var SymfonySerializerInterface|null
     */
    private static ?SymfonySerializerInterface $instance = null;

    /**
     * @return SymfonySerializerInterface
     */
    public static function create(): SymfonySerializerInterface
    {
        if (self::$instance instanceof SymfonySerializerInterface) {
            return self::$instance;
        }

        $classMetadataFactory = new ClassMetadataFactory(
            new LoaderChain(
                [
                    new XmlFileLoader(
                        str_replace(
                            '/',
                            DIRECTORY_SEPARATOR,
                            __DIR__ . '/Config/definition.xml',
                        ),
                    ),
                    new AnnotationLoader(new AnnotationReader()),
                ],
            )
        );

        $reflectionExtractor = new ReflectionExtractor();
        $phpDocExtractor = new PhpDocExtractor();
        $propertyTypeExtractor = new PropertyInfoExtractor(
            [$reflectionExtractor],
            [$phpDocExtractor, $reflectionExtractor],
            [$phpDocExtractor],
            [$reflectionExtractor],
            [$reflectionExtractor],
        );

        $encoders = [new JsonEncoder()];
        $normalizers = [
            new DateTimeNormalizer(),
            new DateTimeZoneNormalizer(),
            new ArrayDenormalizer(),
            new ObjectNormalizer(
                $classMetadataFactory,
                new MetadataAwareNameConverter($classMetadataFactory),
                null,
                $propertyTypeExtractor,
                new ClassDiscriminatorFromClassMetadata($classMetadataFactory),
            ),
        ];

        self::$instance = new SymfonySerializer($normalizers, $encoders);

        return self::$instance;
    }
}
