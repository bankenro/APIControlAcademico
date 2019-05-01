<?php
/**
 * Created by PhpStorm.
 * User: GlobalTIC's
 * Date: 28/02/2018
 * Time: 18:44
 */

require 'fpdf/fpdf.php';

class Reporte extends FPDF {
    private $nombreEP,$nombreAs,$nombreDoc,$titulo;
    public function setNombreEp($nombreEP) {
        $this->nombreEP = $nombreEP;
    }

    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }

    public function setNombreAs($nombreAs) {
        $this->nombreAs = $nombreAs;
    }

    public function setNombreDOC($nombreDoc) {
        $this->nombreDoc = $nombreDoc;
    }

    function Header() {
        $this->Image($_SERVER['DOCUMENT_ROOT'].'/controlacademico/reportes/imagenes/uancv.png', 10, 12, 20, 20, 'PNG');
        $this->Image($_SERVER['DOCUMENT_ROOT'].'/controlacademico/reportes/imagenes/uancv.png', 175, 12, 20, 20, 'PNG');
        //$this->Image('imagenes/uancv.png', 175, 12, 20, 20, 'PNG');
        //$this->Image('imagenes/uancv.png', 175, 12, 20, 20, 'PNG');
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 12);
        /*$this->Cell(0, 4, utf8_decode('Superintendencia Nacional de Educación Superior Universitaria'), 0, 1, 'C');
        $this->SetFont('Arial', 'B', 10);*/
        $this->Cell(0, 4, utf8_decode('Universidad Andina Néstor Cáceres Velasquez'), 0, 1, 'C');
        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 4, utf8_decode($this->nombreEP), 0, 1, 'C');
        $this->SetFont('Arial', 'BU', 14);
        $this->Ln(5);
        $this->Cell(0, 5, utf8_decode($this->titulo), 0, 1, 'C');
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 5, utf8_decode($this->nombreAs), 0, 1, 'R');
        $this->Cell(0, 5, 'Fecha: ' . date('d-m-Y') . '', 0, 1, 'R');
    }

    function Footer() {
        $this->setY(-35);
        $tamao = strlen($this->nombreDoc);
        $array = array();
        for ($i = 0 ;$tamao>$i;$i++){
            $array[$i] = '_';
        }
        $this->Cell(0, 10, implode($array), 0, 0, 'R');
        $this->SetY(-30);
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 10, utf8_decode($this->nombreDoc), 0, 0, 'R');
        $this->SetY(-15);
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}