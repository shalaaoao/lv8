<!doctype html>
<html>
    <head>
        <meta charset='UTF-8/'>
        <title>二叉树显示</title>
    </head>
    <style>
        .tree {
            overflow-x: auto;
            width: 150%; /* 你可以根据需要调整这个值 */
        }

        .tree ul {
            padding-top: 20px; position: relative;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .tree li {
            float: left; text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .tree li::before, .tree li::after{
            content: '';
            position: absolute; top: 0; right: 50%;
            border-top: 1px solid #ccc;
            width: 50%; height: 20px;
        }

        .tree li::after{
            right: auto; left: 50%;
            border-left: 1px solid #ccc;
        }

        .tree li:only-child::after, .tree li:only-child::before {
            display: none;
        }

        .tree li:only-child{ padding-top: 0;}

        .tree li:first-child::before, .tree li:last-child::after{
            border: 0 none;
        }

        .tree li:last-child::before{
            border-right: 1px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }

        .tree li:first-child::after{
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }

        .tree ul ul::before{
            content: '';
            position: absolute; top: 0; left: 50%;
            border-left: 1px solid #ccc;
            width: 0; height: 20px;
        }

        .tree li .ball {
            border: 1px solid #ccc;
            padding: 5px 10px;
            text-decoration: none;
            color: #666;
            /*font-family: arial, verdana, tahoma;*/
            font-size: 15px;
            display: inline-block;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .tree li .ball:hover, .tree li .ball:hover+ul li .ball {
            background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
        }

        .tree li .ball:hover+ul li::after, .tree li .ball:hover+ul li::before, .tree li .ball:hover+ul::before, .tree li .ball:hover+ul ul::before{
            border-color:  #94a0b4;
        }
    </style>

    <body>
    <div class="tree">
    <ul>
        <?php echo $tree; ?>
    </ul>
    </div>
    </body>

</html>
