# Sylius Cms Block Plugin

## Example

### Admin list

Manage your block in admin

![Grid of blocks in Sylius admin](images/blocks-list.jpg)

### Admin form

Manage the content of your block, you can decide to disable or enable it to display it anywhere you used it.

![Form of a block in Sylius Admin](images/block-form.jpg)

### Include it in your content

For example in your [Homepage](https://github.com/monsieurbiz/SyliusHomepagePlugin) ou [CMS Page](https://github.com/monsieurbiz/SyliusCmsPagePlugin/) !

![Block included in a homepage content](images/block-included.jpg)

By using `block` element in your [Rich Editor](https://github.com/monsieurbiz/SyliusRichEditorPlugin/).

![Block element in rich editor](images/block-ui-element.jpg)

Chose the block you want to include in your content.

![Block element in rich editor](images/choose-block.jpg)

### Displays in front

You can use it in multiple places, it will shown the same content everywhere.

![Block displayed in front](images/block-front.jpg)

If you disable the block, it will not be displayed anymore.

## Installation

Run the recipe and run migrations 

```
console doctrine:migrations:migrate -n
```

## License

This plugin is under the MIT license.
Please see the [LICENSE](LICENSE) file for more information.
