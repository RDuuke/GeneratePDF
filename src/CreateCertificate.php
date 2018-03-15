<?php
namespace Certificado;

use Certificado\Database\PDOConexion;
use Mpdf\Mpdf;

class CreateCertificate {

    protected $path = __DIR__ . "/../templates";

    protected $usuario;

    protected $type;

    protected $view;

    protected $template;

    protected $pdo;

    protected $pdf;

    function __construct(Usuario $usuario, Mpdf $pdf, \PDO $pdo) {
        $loader = new \Twig_Loader_Filesystem($this->path);
        $this->view = new \Twig_Environment($loader, ['cache' => false]);
        $this->view->getExtension("Twig_Extension_Core")->setTimezone("America/Bogota");
        $this->template .= $usuario->template . DS . $usuario->template . ".twig";
        $this->usuario = $usuario;
        $this->pdo = $pdo;
        $this->pdf = $pdf;
    }

    function render()
    {
        $html = $this->view->render($this->template, [
            'usuario'  => $this->usuario->all(),
            'fecha' => date("d/m/Y")
            ]);

        $this->pdf->Addpage('L');
        $this->pdf->showImageErrors = true.
        //$this->pdf->WriteHtml($css,1);
        $this->pdf->WriteHtml($html);
        $this->pdf->Image($this->path . DS. "img" .DS . strtolower($this->usuario->template) . ".jpg", 0, 0, 297, 210, 'jpg', '', true, false);
        return $this->pdf->Output();
    }

}