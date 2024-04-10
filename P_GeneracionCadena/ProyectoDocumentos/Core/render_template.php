<?php

class RenderTemplate
{
    public $file = "";
    public $data = array();
    protected $comodines = array();
    protected $values = array();
    public $html = "";
    # Traer contenido HTML de una plantilla 
    protected function get_html($str = NULL)
    {
        return isset($str) ? $str : file_get_contents($this->file);
    }
    # Setear comodines y valores 
    public function set_data($data = array())
    {
        $this->comodines = array_keys($data);
        $this->values = array_values($data);
        $this->set_comodines();
    }
    # Modificar comodines (envolver entre llaves) 
    private function set_comodines()
    {
        foreach ($this->comodines as &$comodin) {
            $comodin = "{" . $comodin . "}";
        }
    }
    # Renderizar plantilla 
    public function render_template($str = NULL)
    {
        $this->html .= str_replace(
            $this->comodines,
            $this->values,
            $this->get_html($str)
        );
    }
}
