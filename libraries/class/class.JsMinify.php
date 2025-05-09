<?php
class JsMinify
{
    private $path = array();
    private $debug;
    private $access = array(
        'server' => ROOT . 'assets/',
        'asset' => ASSET . 'assets/',
        'folder' => 'caches/'
    );
    private $cacheName = '';
    private $cacheFile = '';
    private $cacheLink = '';
    private $cacheSize = false;
    private $cacheTime = 3600 * 24 * 30;
    private $file = [];
    private $lock = array(
        'status' => false,
        'char' => ''
    );

    function __construct($debug, $func)
    {
        $this->debug = $debug;
        $this->func = $func;
    }

    public function init($name)
    {
        if (!$this->debug && !file_exists($this->cacheLink . $this->access['server'] . $this->access['folder'])) {
            if (!mkdir($this->cacheLink . $this->access['server'] . $this->access['folder'], 0777, true)) {
                die('Failed to create folders...');
            }
        }

        $this->cacheName = $name;
        $this->cacheFile = $this->cacheFile . $this->access['server'] . $this->access['folder'] . $this->cacheName . '.js';
        $this->cacheLink = $this->cacheLink . $this->access['asset'] . $this->access['folder'] . $this->cacheName . '.js';
        $this->cacheSize = (file_exists($this->cacheFile)) ? filesize($this->cacheFile) : 0;
    }

    public function set($path)
    {
        $this->path[] = [
            'server' => $this->access['server'] . $path,
            'asset' => $this->access['asset'] . $path
        ];

        $this->file[] = $path;
    }

    public function get()
    {
        $this->init(md5(implode(",", $this->file)));
        if (empty($this->path)) die("No files to optimize");
        return ($this->debug) ? $this->links() : $this->minify();
    }

    private function minify()
    {
        $strJs = '';
        $extension = '';

        if (!$this->cacheSize || $this->isExpire($this->cacheFile)) {
            foreach ($this->path as $path) {
                $parts = pathinfo($path['server']);
                $extension = strtolower($parts['extension']);
                if ($extension != 'js') die("Invalid file");
                $myfile = fopen($path['server'], "r") or die("Unable to open file");
                $sizefile = filesize($path['server']);
                if ($sizefile) $strJs .= $this->compress(fread($myfile, $sizefile));
                fclose($myfile);
            }

            if ($strJs) {
                $file = fopen($this->cacheFile, "w") or die("Unable to open file");
                fwrite($file, $strJs);
                fclose($file);
            }
        }

        return '<script type="text/javascript" src="' . $this->cacheLink . '?v=' . filemtime($this->cacheFile) . '"></script>';
    }

    private function links()
    {
        $linkJs = '';
        $extension = '';

        if ($this->cacheSize) {
            $file = fopen($this->cacheFile, "r+") or die("Unable to open file");
            ftruncate($file, 0);
            fclose($file);
        }

        foreach ($this->path as $path) {
            $parts = pathinfo($path['server']);
            $extension = strtolower($parts['extension']);
            if ($extension != 'js') die("Invalid file");
            $linkJs .= '<script type="text/javascript" src="' . $path['asset'] . '?v=' . $this->func->stringRandom(10) . '"></script>' . PHP_EOL;
        }

        return $linkJs;
    }

    private function isExpire($file)
    {
        $fileTime = filemtime($file);
        $isExpire = false;

        if ((time() - $fileTime) > $this->cacheTime) {
            $isExpire = true;
        }

        return $isExpire;
    }

    private function compress($js)
    {
        // Remove single-line code comments
        $js = preg_replace('/^[\t ]*?\/\/.*\s?/m', '', $js);

        // Remove end-of-line code comments
        $js = preg_replace('/([\s;})]+)\/\/.*/m', '\\1', $js);

        // Remove multi-line code comments
        // $js = preg_replace('/\/\*[\s\S]*?\*\//', '', $js);
        $js = preg_replace('/(\s+)\/\*([^\/]*)\*\/(\s+)/s', "\n", $js);

        // Remove leading whitespace
        $js = preg_replace('/^\s*/m', '', $js);

        // Replace multiple tabs with a single space
        $js = preg_replace('/\t+/m', ' ', $js);

        // Remove newlines
        $js = preg_replace('/[\r\n]+/', '', $js);

        // Split input JavaScript by single and double quotes
        $js_substrings = preg_split('/([\'"])/', $js, -1, PREG_SPLIT_DELIM_CAPTURE);

        // Empty variable for minified JavaScript
        $js = '';

        foreach ($js_substrings as $substring) {
            // Check if substring is split delimiter
            if ($substring === '\'' or $substring === '"') {
                // If so, check whether minification is unlocked
                if ($this->lock['status'] === false) {
                    // If so, lock it and set lock character
                    $this->lock['status'] = true;
                    $this->lock['char'] = $substring;
                } else {
                    // If not, check if substring is lock character
                    if ($substring === $this->lock['char']) {
                        // If so, unlock minification
                        $this->lock['status'] = false;
                        $this->lock['char'] = '';
                    }
                }

                // Add substring to minified output
                $js .= $substring;
                continue;
            }

            // Minify current substring if minification is unlocked
            if ($this->lock['status'] === false) {
                // Remove unnecessary semicolons
                $substring = str_replace(';}', '}', $substring);

                // Remove spaces round operators
                $substring = preg_replace('/ *([<>=+\-!\|{(},;&:?]+) */', '\\1', $substring);
            }

            // Add substring to minified output
            $js .= $substring;
        }

        return trim($js);
    }
}
