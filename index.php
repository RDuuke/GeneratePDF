<?php
require_once "vendor/autoload.php";
use Certificado\CreateCertificate;
use Certificado\Usuario;
use Certificado\Database\PDOConexion;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Language\LanguageToFontInterface;
define( "DS" , DIRECTORY_SEPARATOR);
$tipo = 2;
$pdo = PDOConexion::instance()->getConexion();
$usuario = new Usuario('1038409053', 'vocacional', 2, $pdo);
$defaultConfig = (new ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
if ($tipo > 0) {
        $configuration = [
                'fontDir' => array_merge($fontDirs,[__DIR__ . "/templates/fonts"]),
                'fontdata' => $fontData + [
                        'roboto_cod' => [
                                'R' => 'Roboto-Condensed.ttf',
                                'B' => 'Roboto-BoldCondensed.ttf',
                        ],
                        'roboto_light' => [
                                'R' => 'Roboto-Light.ttf'
                        ],
                        'the_black' => [
                                'R' => 'The-Blacklist.ttf'
                        ]
                        ],
                'default_font' => 'roboto_cod'];
} else {
        $configuration = [
                'fontDir' => array_merge($fontDirs,[__DIR__ . "/templates/fonts"]),
                'fontdata' => $fontData + [
                        'roboto' => [
                                'R' => 'Roboto-Medium.ttf',
                                'B' => 'Roboto-MediumItalic.ttf',
                        ]
                        ],
                'default_font' => 'roboto'];
}


$mpdf = new Mpdf($configuration);

$certificado = new CreateCertificate($usuario->find()->get(), $mpdf, $pdo);

$certificado->render();