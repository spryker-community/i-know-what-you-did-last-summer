<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ShoppingListPage;

use Spryker\Client\AvailabilityStorage\Plugin\ProductViewAvailabilityStorageExpanderPlugin;
use Spryker\Client\PriceProductStorage\Plugin\ProductViewPriceExpanderPlugin;
use Spryker\Client\ProductImageStorage\Plugin\ProductViewImageExpanderPlugin;
use SprykerShop\Yves\ProductOptionWidget\Plugin\ShoppingListPage\ShoppingListItemProductOptionFormDataProviderMapperPlugin;
use SprykerShop\Yves\ProductOptionWidget\Plugin\ShoppingListPage\ShoppingListItemProductOptionFormExpanderPlugin;
use SprykerShop\Yves\ProductOptionWidget\Plugin\ShoppingListPage\ShoppingListItemProductOptionWidgetPlugin;
use SprykerShop\Yves\ShoppingListNoteWidget\Plugin\ShoppingListPage\ShoppingListItemNoteFormExpanderPlugin;
use SprykerShop\Yves\ShoppingListPage\ShoppingListPageDependencyProvider as SprykerShoppingListPageDependencyProvider;

class ShoppingListPageDependencyProvider extends SprykerShoppingListPageDependencyProvider
{
    /**
     * @return \Spryker\Client\ProductStorage\Dependency\Plugin\ProductViewExpanderPluginInterface[]
     */
    protected function getShoppingListItemExpanderPlugins(): array
    {
        return [
            new ProductViewPriceExpanderPlugin(),
            new ProductViewImageExpanderPlugin(),
            new ProductViewAvailabilityStorageExpanderPlugin(),
        ];
    }

    /**
     * @return string[]
     */
    protected function getShoppingListWidgetPlugins(): array
    {
        return [];
    }

    /**
     * @return \SprykerShop\Yves\ShoppingListPageExtension\Dependency\Plugin\ShoppingListItemFormExpanderPluginInterface[]
     */
    protected function getShoppingListItemFormExpanderPlugins(): array
    {
        return [
            new ShoppingListItemNoteFormExpanderPlugin(), #ShoppingListNoteFeature
            new ShoppingListItemProductOptionFormExpanderPlugin(),
        ];
    }

    /**
     * Returns a list of widget plugin class names that implement
     * \Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface.
     *
     * @return string[]
     */
    protected function getShoppingListViewWidgetPlugins(): array
    {
        return [
            ShoppingListItemProductOptionWidgetPlugin::class,
        ];
    }

    /**
     * Returns a list of widget plugin class names that implement
     * \Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface.
     *
     * @return string[]
     */
    protected function getShoppingListEditWidgetPlugins(): array
    {
        return [];
    }

    /**
     * @return \SprykerShop\Yves\ShoppingListPageExtension\Dependency\Plugin\ShoppingListFormDataProviderMapperPluginInterface[]
     */
    protected function getShoppingListFormDataProviderMapperPlugins(): array
    {
        return [
            new ShoppingListItemProductOptionFormDataProviderMapperPlugin(),
        ];
    }
}
