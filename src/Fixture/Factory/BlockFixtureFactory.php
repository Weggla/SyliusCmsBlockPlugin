<?php

/*
 * This file is part of Monsieur Biz's Sylius Cms Block Plugin for Sylius.
 * (c) Monsieur Biz <sylius@monsieurbiz.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MonsieurBiz\SyliusCmsBlockPlugin\Fixture\Factory;

use Faker\Generator;
use MonsieurBiz\SyliusCmsBlockPlugin\Entity\BlockInterface;
use MonsieurBiz\SyliusCmsBlockPlugin\Entity\BlockTranslationInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Product\Generator\SlugGeneratorInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlockFixtureFactory extends AbstractExampleFactory implements BlockFixtureFactoryInterface
{
    private OptionsResolver $optionsResolver;

    private Generator $faker;

    public function __construct(
        private FactoryInterface $blockFactory,
        private FactoryInterface $blockTranslationFactory,
        private SlugGeneratorInterface $slugGenerator,
        private RepositoryInterface $localeRepository
    ) {
        $this->blockFactory = $blockFactory;
        $this->blockTranslationFactory = $blockTranslationFactory;
        $this->localeRepository = $localeRepository;

        $this->slugGenerator = $slugGenerator;
        $this->faker = \Faker\Factory::create();

        $this->optionsResolver = new OptionsResolver();
        $this->configureOptions($this->optionsResolver);
    }

    public function create(array $options = []): BlockInterface
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var BlockInterface $block */
        $block = $this->blockFactory->createNew();
        $block->setEnabled($options['enabled']);
        $block->setCode($options['code']);

        $this->createTranslations($block, $options);

        return $block;
    }

    private function createTranslations(BlockInterface $block, array $options): void
    {
        foreach ($options['translations'] as $localeCode => $translation) {
            /** @var BlockTranslationInterface $blockTranslation */
            $blockTranslation = $this->blockTranslationFactory->createNew();
            $blockTranslation->setLocale($localeCode);
            $blockTranslation->setName($translation['name']);
            $blockTranslation->setContent($translation['content']);

            $block->addTranslation($blockTranslation);
        }
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('enabled', function (Options $options): bool {
                return $this->faker->boolean(80);
            })
            ->setDefault('code', function (Options $options): string {
                return $this->slugGenerator->generate($this->faker->sentence(2, true));
            })
            ->setDefault('translations', function (OptionsResolver $translationResolver): void {
                $translationResolver->setDefaults($this->configureDefaultTranslations());
            })
        ;
    }

    private function configureDefaultTranslations(): array
    {
        $translations = [];
        $locales = $this->localeRepository->findAll();
        /** @var LocaleInterface $locale */
        foreach ($locales as $locale) {
            $name = ucfirst($this->faker->sentence(3, true));
            $translations[$locale->getCode()] = [
                'name' => $name,
                'content' => $this->faker->paragraphs(3, true),
            ];
        }

        return $translations;
    }
}
