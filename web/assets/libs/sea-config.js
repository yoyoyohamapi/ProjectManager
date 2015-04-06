seajs.config({
    base: "/assets/libs/",
    alias: {
        "jquery": "jquery/1.10.1/jquery.js",
        "$": "jquery/1.10.1/jquery.js",
        "arale-base": "arale-base/1.2.0/base.js",
        "cscv-app-base": "cscv-app-base/1.0.0/cscv-app-base.js",
        "semantic-ui": "semantic-ui/1.6.3/build/semantic.min.js",
        "transit": "transit/0.9.9/jquery.transit.js",
        'map': [
            [/^(.*\.(?:css|js))(.*)$/i, '$1?20140801']
        ]
    }
})

