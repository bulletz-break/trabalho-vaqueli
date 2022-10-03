<?php
defined('BASEPATH') OR exit('Sem acesso direto :D');

// Controlador para navegação no site
class App extends CI_Controller {
    public function index() { return $this->home(); }

    public function home() {
        $this->Page->append('css', 'top_bar', base_url('assets/css/header/'));
        $this->Page->append('css', 'home', base_url('assets/css/content/'));
        $this->Page->append('css', 'rodape', base_url('assets/css/footer/'));

        $this->Page->append('header', $this->load->view('header/top_bar', [], TRUE));
        $this->Page->append('main', $this->load->view('content/home', [], TRUE));
        $this->Page->append('footer', $this->load->view('footer/rodape', [], TRUE));

        $this->load->view('page', ['page' => $this->Page->build()]);
    }
}

?>