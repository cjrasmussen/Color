# Color

Simple functions for color conversion and analysis.


## Usage

```php
use cjrasmussen\Color\Convert;
use cjrasmussen\Color\General;

$hex = Convert::rgbToHex(153, 51, 51);
echo $hex; // 993333

$rgb = (object)[
	'R' => 153,
	'G' => 51,
	'B' => 51,
];
$hex = Convert::rgbToHex($rgb);
echo $hex; // 993333

$is_hex = General::isHexColor('993333');
echo $is_hex; // true
```

## Installation

Simply add a dependency on cjrasmussen/color to your composer.json file if you use [Composer](https://getcomposer.org/) to manage the dependencies of your project:

```sh
composer require cjrasmussen/color
```

Although it's recommended to use Composer, you can actually include the file(s) any way you want.


## License

Color is [MIT](http://opensource.org/licenses/MIT) licensed.