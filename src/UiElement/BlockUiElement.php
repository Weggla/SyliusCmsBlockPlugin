<?php

/*
 * This file is part of Monsieur Biz's Sylius Cms Block Plugin for Sylius.
 * (c) Monsieur Biz <sylius@monsieurbiz.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MonsieurBiz\SyliusCmsBlockPlugin\UiElement;

use MonsieurBiz\SyliusCmsBlockPlugin\Entity\BlockInterface;
use MonsieurBiz\SyliusCmsBlockPlugin\Repository\BlockRepositoryInterface;
use MonsieurBiz\SyliusRichEditorPlugin\UiElement\UiElementInterface;
use MonsieurBiz\SyliusRichEditorPlugin\UiElement\UiElementTrait;

final class BlockUiElement implements UiElementInterface
{
    use UiElementTrait;

    public function __construct(
        private BlockRepositoryInterface $blockRepository,
    ) {
    }

    public function getBlock(string $id): ?BlockInterface
    {
        /** @phpstan-ignore-next-line */
        return $this->blockRepository->find($id);
    }
}
