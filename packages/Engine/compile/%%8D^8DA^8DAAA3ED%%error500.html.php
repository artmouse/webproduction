<?php /* Smarty version 2.6.27-optimized, created on 2015-12-20 19:18:06
         compiled from /var/www/shop.local//templates/default/error/error500.html */ ?>
<!DOCTYPE html>
<html>
<head>
    <title>Internal server error</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <style>
        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            padding: 20px;;
            font-family: Arial;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            background-color: #f6f7f9;
        }

        h1 {
            padding: 0;
            margin: 0 0 20px 0;
            font-size: 20px;
        }

        code {
            padding: 10px;
            display: block;
            background: url("/_images/admin/code-bg.png") right top no-repeat #ffffff;
            border: 1px dashed rgba(0, 0, 0, 0.25);
            overflow: auto;
            margin: 0 0 20px 0;
        }

        code pre {
            padding: 0;
            margin: 0;
        }
    </style>
</head>
<body>
    <h1>Internal server error</h1>
    <code><pre><?php echo $this->_tpl_vars['exception']; ?>
</pre></code>
</body>
</html>