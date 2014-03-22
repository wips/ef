<?php
namespace Ef\Storage {
    use Symfony\Component\HttpFoundation\Request;

    class FilterBuilder {
        function build(Request $request) {
            return array(
                $request->get('width'),
                $request->get('height'),
                $request->get('title'),
                $request->get('user'),
                $request->get('url')
            );
        }
    }
}

 