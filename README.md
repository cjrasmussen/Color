# Color

Simple functions for color conversion and analysis.

## Usage

```php
use cjrasmussen\Color\ColorType\Hex;
use cjrasmussen\Color\ColorType\Rgb;
use cjrasmussen\Color\General;

$rgb = new Rgb(153, 51, 51);
$hex = $rgb->toHex();
echo $hex; // 993333

$is_hex = General::isHexColor('993333');
echo $is_hex; // true

$hex = new Hex('993333');
$rgb = $hex->toRgb();
```

There are no methods for directly converting Hex/HSL/HSV to Hex/HSL/HSV (or for getting luminence of Hex/HSL/HSV) but RGB can be used as a stepping-stone.

```php
$hsl = (new Hex('#800'))->toRgb()->toHsl();
```


## Installation

Simply add a dependency on cjrasmussen/color to your composer.json file if you use [Composer](https://getcomposer.org/) to manage the dependencies of your project:

```sh
composer require cjrasmussen/color
```

Although it's recommended to use Composer, you can actually include the file(s) any way you want.

## License

Color is [MIT](http://opensource.org/licenses/MIT) licensed.