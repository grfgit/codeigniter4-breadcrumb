<?php
namespace GRFG\Breadcrumb;

use Config\App;

class Breadcrumbs {

    private $breadcrumbs = [];
    private $tag_open;
    private $tag_close;
    private $crumb_open;
    private $crumb_close;
    private $crumb_last_open;
    private $site_map;
    private $current_map = [];

    /**
     * Constructor
     *
     * @access	public
     *
     */
    public function __construct()
    {
        if (class_exists(Config\Breadcrumb::class))
            $breadcrumb_config = config(Config\Breadcrumb::class);
        else
            $breadcrumb_config = config(GRFG\Breadcrumb\Config\Breadcrumb::class);
        $app_config = config(App::class);

        $this->tag_open = $breadcrumb_config->tagOpen;
        $this->tag_close = $breadcrumb_config->tagClose;
        $this->crumb_open = $breadcrumb_config->crumbOpen;
        $this->crumb_close = $breadcrumb_config->crumbClose;
        $this->crumb_last_open = $breadcrumb_config->crumbLastOpen;
        $this->site_map = $app_config->siteMap;
    }

    public function set($page)
    {
        if (!key_exists($page, $this->site_map))
            return '';

        if (key_exists('parent', $this->site_map[$page]))
            $this->setPush($this->site_map[$page]);
        else
            $this->current_map[] = [
                'title' => $this->site_map[$page]['title'],
                'url' => $this->site_map[$page]['url']
            ];

        $this->current_map = array_reverse($this->current_map);

        foreach ($this->current_map as $map)
            $this->push($map['title'], $map['url']);

        return $this->show();
    }

    public function setPush($parent)
    {
        $this->current_map[] = [
            'title' => $parent['title'],
            'url' => $parent['url']
        ];

        if (key_exists('parent', $parent))
            return $this->setPush($parent['parent']);
    }

    // --------------------------------------------------------------------

    /**
     * Append crumb to stack
     *
     * @access	public
     * @param	string $page
     * @param	string $href
     * @return	void
     */
    public function push($page, $href)
    {
        // no page or href provided
        if (!$page OR !$href) return;

        // Prepend site url
        $href = site_url($href);

        // push breadcrumb
        $this->breadcrumbs[$href] = ['page' => $page, 'href' => $href];
    }

    // --------------------------------------------------------------------

    /**
     * Prepend crumb to stack
     *
     * @access	public
     * @param	string $page
     * @param	string $href
     * @return	void
     */
    public function unshift($page, $href)
    {
        // no crumb provided
        if (!$page OR !$href) return;

        // Prepend site url
        $href = site_url($href);

        // add at firts
        array_unshift($this->breadcrumbs, ['page' => $page, 'href' => $href]);
    }

    // --------------------------------------------------------------------

    /**
     * Generate breadcrumb
     *
     * @access	public
     * @return	string
     */
    public function show()
    {
        if ($this->breadcrumbs) {

            // set output variable
            $output = $this->tag_open;
            $output .= '<li class="breadcrumb-item"><a href="' . base_url('/') . '"><i class="bx bx-home-alt"></i></a></li>';

            // construct output
            foreach ($this->breadcrumbs as $key => $crumb) {
                $keys = array_keys($this->breadcrumbs);
                if (end($keys) == $key) {
                    $output .= $this->crumb_last_open . '' . $crumb['page'] . '' . $this->crumb_close;
                } else {
                    $output .= $this->crumb_open.'<a href="' . $crumb['href'] . '">' . $crumb['page'] . '</a> '.$this->crumb_close;
                }
            }

            // return output
            return $output . $this->tag_close . PHP_EOL;
        }

        // no crumbs
        return '';
    }

}
// END Breadcrumbs Class

/* End of file Breadcrumbs.php */
/* Location: ./application/libraries/Breadcrumbs.php */
