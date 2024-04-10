<?php
class RenderData extends RenderTemplate
{
    protected $pattern_tags = array();
    protected $pattern = "";
    # Setear pattern tags 
    protected function set_tag($tag)
    {
        $this->pattern_tags = array(
            "<!-- ini-loop: {$tag} -->",
            "<!-- end-loop: {$tag} -->"
        );
    }
    # Obtener posición de los pattern tags 
    private function get_position($tag)
    {
        return strpos($this->get_html(), $this->pattern_tags[$tag]);
    }
    # Obtener longitud total del pattern 
    private function get_longitud()
    {
        $longitud = $this->get_position(1) - $this->get_position(0);
        return $longitud + strlen($this->pattern_tags[1]);
    }
    # Setear el contenido del pattern 
    protected function set_pattern_content()
    {
        $this->pattern = substr(
            $this->get_html(),
            $this->get_position(0),
            $this->get_longitud()
        );
    }
    # Eliminar el patrón HTML y sustituirlo por el render 
    private function delete_pattern()
    {
        $str_final = str_replace($this->pattern_tags, "", $this->html);
        return str_replace($this->pattern, $str_final, $this->get_html());
    }
    # Renderizar datos 
    public function render_data($tag, $data)
    {
        $this->set_tag($tag);
        $this->set_pattern_content();
        foreach ($data as $array) {
            $this->set_data($array);
            $this->render_template($this->pattern);
        }


        $this->html = $this->delete_pattern();
    }
}
