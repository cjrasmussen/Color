# Color

Simple functions for color conversion and analysis.


## Usage

```php
use cjrasmussen\Color;

$hex = Color::convertRgbToHex(153, 51, 51);
echo $hex; // 993333

$rgb = (object)[
	'R' => 153,
	'G' => 51,
	'B' => 51,
];
$hex = Color::convertRgbToHex($rgb);
echo $hex; // 993333
```

## Installation

Simply add a dependency on cjrasmussen/color to your composer.json file if you use [Composer](https://getcomposer.org/) to manage the dependencies of your project:

```sh
composer require cjrasmussen/color
```

Although it's recommended to use Composer, you can actually include the file(s) any way you want.


## License

Color is [MIT](http://opensource.org/licenses/MIT) licensed.