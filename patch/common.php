<?php
function parserIfLabel($content)
{
    $pattern = '/\{pboot:if\(([^}^\$]+)\)\}([\s\S]*?)\{\/pboot:if\}/';
    $pattern2 = '/pboot:([0-9])+if/';
    if (preg_match_all($pattern, $content, $matches)) {
        $count = count($matches[0]);
        for ($i = 0; $i < $count; $i++) {
            $flag = '';
            $out_html = '';
            $danger = false;

            $white_fun = array(
                'date'
            );

            // 还原可能包含的保留内容，避免判断失效

            // 带有函数的条件语句进行安全校验
            if (preg_match_all('/([\w]+)([\x00-\x1F\x7F\/\*\<\>\%\w\s\\\\]+)?\(/i', $matches[1][$i], $matches2)) {
                foreach ($matches2[1] as $value) {
                    if (function_exists(trim($value)) && !in_array($value, $white_fun)) {
                        $danger = true;
                        break;
                    }
                }

                foreach ($matches2[2] as $value) {
                    if (function_exists(trim($value)) && !in_array($value, $white_fun)) {
                        $danger = true;
                        break;
                    }
                }
            }

            // 过滤特殊字符串

            if (preg_match('/(\([\w\s\.]+\))|(\$_GET)|(\$_POST)|(\$_REQUEST)|(\$_COOKIE)|(\$_SESSION)|(\])|(\[)|(\$)|(file_put_contents)|(file_get_contents)|(fwrite)|(base64_decode)|(`)|(shell_exec)|(eval)|(assert)|(system)|(exec)|(passthru)|(pcntl_exec)|(popen)|(proc_open)|(print_r)|(print)|(urldecode)|(chr)|(include)|(request)|(__FILE__)|(__DIR__)|(copy)|(call_user_)|(preg)|(reg)|(new)|(array)|(sort)|(function)|(getallheaders)|(get_headers)|(decode_string)|(htmlspecialchars)|(session)|(strrev)|(substr)|(php.info)|(@file.@_put_content)/i', $matches[1][$i])) {
                $danger = true;
            }

            // 如果有危险函数，则不解析该IF
            if ($danger) {
                continue;
            }
            eval('if(' . $matches[1][$i] . '){$flag="if";}else{$flag="else";}');
            if (preg_match('/^([\s\S]*)\{else\}([\s\S]*)$/', $matches[2][$i], $matches2)) { // 判断是否存在else
                switch ($flag) {
                    case 'if': // 条件为真
                        if (isset($matches2[1])) {
                            $out_html = $matches2[1];
                        }
                        break;
                    case 'else': // 条件为假
                        if (isset($matches2[2])) {
                            $out_html = $matches2[2];
                        }
                        break;
                }
            } elseif ($flag == 'if') {
                $out_html = $matches[2][$i];
            }

            // 无限极嵌套解析
            if (preg_match($pattern2, $out_html, $matches3)) {
                $out_html = str_replace('pboot:' . $matches3[1] . 'if', 'pboot:if', $out_html);
                $out_html = str_replace('{' . $matches3[1] . 'else}', '{else}', $out_html);
                $out_html = parserIfLabel($out_html);
            }

            // 执行替换
            $content = str_replace($matches[0][$i], $out_html, $content);
        }
    }
    return $content;
}
class my_template{
    public $head='hello';
    public $foot='end';
    public $name='';
    public $res='';
    public function display(){
        $data=file_get_contents('./html/index.html');
        $data=preg_replace('/\{\{name\}\}/',$this->name,$data);
        $data=preg_replace('/\{\{head\}\}/',$this->head,$data);
        $data=preg_replace('/\{\{foot\}\}/',$this->foot,$data);
        $data=preg_replace('/\{\{res\}\}/',$this->res,$data);
        echo ($data);

    }
}