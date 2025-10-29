<!DOCTYPE html>
<html>
<head>
    <title>五子棋</title>
    <style>
        .container {
            padding: 20px;
        }

        .chessboard {
            background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9ImhHRlBNTS9uZXQvMS4wL3N0cmlwLyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChNYWNpbnRvc2gpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjAxODAxMTc0MDcyMDExRTg4RjY5ODM5RUM3MjhFMTk2IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjAxODAxMTc0MDcyMDExRTg4RjY5ODM5RUM3MjhFMTk2Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MDE4MDExNzQwNzIwMTFFODhGNjk4MzlFQzcyOEUxOTYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MDE4MDExNzQwNzIwMTFFODhGNjk4MzlFQzcyOEUxOTYiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4u/mvCAAAAVUlEQVR42mJgQAP/0eQY0QSYsAVYWFgYzp8/jyXHhF0LmoDx48cZzp49y8CCJcCMrQlMZPjw4QxHjx5lYMYSYMYVjFgCjowjDBBBYAAIMABsUQvjnq3wKAAAAABJRU5ErkJggg=='); /* 木质纹理 */
            padding: 20px;
            border-radius: 5px;
        }

        table {
            border-collapse: collapse;
            border: 2px solid #654321;
            /*width: 100%;*/
        }

        td {
            width: 60px;
            height: 60px;
            position: relative;
            border: 1px solid rgba(101, 67, 33, 0.3);
        }

        .stone {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .black {
            background: #333;
            border: 1px solid #000;
        }

        .white {
            background: #fff;
            border: 1px solid #ddd;
        }

        /* 新增最后落子标记样式 */
        .last-move::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 32px;
            height: 32px;
            border: 2px solid #ff0000;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% { opacity: 0.8; }
            50% { opacity: 0.3; transform: translate(-50%, -50%) scale(1.2); }
            100% { opacity: 0.8; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="chessboard">
        <table>
            @foreach ($chessboard as $x => $row)
                <tr>
                    @foreach ($row as $y => $cell)
                        @php
                            $isLast = $lastProducer &&
                                     $lastProducer[0] === $cell &&
                                     $lastProducer[1] == $x &&
                                     $lastProducer[2] == $y;
                        @endphp
                        <td class="{{ $isLast ? 'last-move' : '' }}">
                            @if ($cell === 1)
                                <div class="stone black"></div>
                            @elseif ($cell === 2)
                                <div class="stone white"></div>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
</div>
</body>
</html>
