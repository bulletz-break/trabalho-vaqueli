<?php
defined('BASEPATH') OR exit('Sem acesso direto :D');

class Page_model extends CI_Model {
    // -----------------------------------------------------------------------
    // ESTRUTURA DA PÁGINA
    /*
     * Título
     * CSS
     * JS ( Comentários: /* | Função: (function funcao() { return; }) )
     * Cabeçalho
     * Conteúdo principal
     * Rodapé
     */
    // -----------------------------------------------------------------------
    // Atributos
    private $head;
    private $title;
    private $css;
    private $js;
    private $header;
    private $main;
    private $footer;

    // -----------------------------------------------------------------------
    // FUNCTIONS
    // Esta função adiciona o conteúdo básico na página
    public function __construct() {
        parent::__construct();
        $this->head = 
        '<meta charset="UTF-8">'.
        '<meta name="viewport" content="width=device-width, initial-scale=1.0">'.
        '<link rel="stylesheet" href="'.base_url('assets/css/default.css').'"/>'.
        '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">'.
        '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>';
    }

    // Esta função retorna a página HTML com todo o conteúdo em forma de string
    public function build() {
        $this->head .= '<style>'.$this->css.'</style>';
        $this->head .= '<script>'.$this->js.'</script>';
        $this->head .= '<title>'.$this->title.'</title>';

        return
        '<!DOCTYPE html>'.
        '<head>'.
            $this->head.
        '</head>'.
        '<body>'.
            '<header id="header">'.
                $this->header.
            '</header>'.
            '<main id="main">'.
                $this->main.
            '</main>'.
            '<footer id="footer">'.
                $this->footer.
            '</footer>'.
        '</body>'.
        '</html>';
    }

    /**
     * @param String $title
     * Novo título da página
     * 
     * Esta função altera o título da página
     */
    public function set_title($title) {
        $this->title = $title;
        return TRUE;
    }

    /**
     * @param String $append
     * O tipo de conteúdo que será adicionado (css, js, header, main, footer)
     * 
     * @param String $file
     * O conteúdo/arquivo para adicionar
     * 
     * @param String $path
     * O diretório em que o arquivo está (opcional)
     * OBS: apenas para arquivos CSS e JS
     * 
     * Esta função recebe o tipo de conteúdo e o nome do arquivo em que está e o adiciona na estrutura da página em forma de string
     */
    public function append($append, $file, $path = FALSE, $props = FALSE) {
        $props_string = '';
        // Adicionando o conteúdo
        switch($append) {
            case 'css': {
                $this->head .= '<link rel="stylesheet" type="text/css" href="'.$path.$file.'.css"/>';
                break;
            }
            case 'js': {
                if($props !== FALSE)
                    foreach($props as $k => $v)
                        $props_string .= $k.'="'.$v.'"';

                $this->head .= '<script src="'.$path.$file.'.js" '.$props_string.'></script>';
                break;
            }
            default: {
                if(is_array($file)) // Mais de 1 conteúdo
                    foreach($file as $content)
                        $this->$append .= $this->unformat($content);
                else
                    $this->$append .= $this->unformat($file);
                break;
            }
        }
        return TRUE;
    }

    /**
     * @param String $string
     * String que será desformatada
     * 
     * Esta função remove formatações de uma string como tabulações, quebras de linha, etc.
     */
    private function unformat($string) {
        return str_replace(["\r", "\n", "\r\n", "\n\r", "    ", "   ", "  "], '', $string);
    }
}