<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends MX_Controller
{
    public function __construct()
    {

        parent::__construct();

        if(!$this->input->is_ajax_request())
        {
            show_404();
            exit();
        }
        else
        {

            $this->load->model('Registro_model', 'Model');
        }
    }

    public function getReporte()//Imprimir
    {

        $data = json_decode($this->input->post('data'), true);

        $id = $this->input->post('id');
        date_default_timezone_set('America/Bogota');
        $data['id'] = $id;
        $data['fecha'] = date("Y-m-d ");
        $data['usuario'] = $this->session->session_nombre_apps;
        $result = $this->Model->reporteIngreso($id);
        $data['resultados'] = $result;

        $html = $this->load->view('ReportePlasmaView', $data, TRUE);
        $pdf = new Pdf('P', 'mm', 'A4', TRUE, 'UTF-8', FALSE);
        $pdf->SetTitle('Reporte de plasma');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(40);
        $pdf->SetMargins(25, 20, 20, TRUE);
        $pdf->SetAutoPageBreak(TRUE);
        $pdf->SetAuthor('Pontificia Universidad Católica del Ecuador');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(FALSE);
        $pdf->setPrintFooter(FALSE);
        $pdf->AddPage();
        $pdf->writeHTML($html, TRUE, 0, TRUE, 0);
        $filename = $this->config->item('upload_dir_plasma') . 'plasmaReporte.pdf';

        $pdf->Output($filename, 'F');
        echo('../documentos/plasma/plasmaReporte.pdf');
    }
}