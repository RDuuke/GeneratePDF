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

$pdo = PDOConexion::instance()->getConexion();
$usuario = new Usuario('1038409053', 'vocacional', 0, $pdo);
$defaultConfig = (new ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new Mpdf([
                'fontDir' => array_merge($fontDirs,[__DIR__ . "/templates/fonts"]),
                'fontdata' => $fontData + [
                        'roboto' => [
                            'R' => 'Roboto-Medium.ttf',
                            'I' => 'Roboto-MediumItalic.ttf'
                        ]
                        ],
                'default_font' => 'roboto']
        );

$certificado = new CreateCertificate($usuario->find()->get(), $mpdf, $pdo);

$certificado->render();