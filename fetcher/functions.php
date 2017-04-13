<?php

function get_version($name, $data, $addBr = true)
{
	if (empty($data[$name]['version'])) {
		return 'N/A';
	} else {
		return 'Current version is <b>' . $data[$name]['version'] . '</b>.' . ($addBr ? '<br/><small>' : ' ') . 'Released ' . days_ago($data[$name]['daysAgo']) . ($addBr ? '</small>' : '');
	}
}

function get_download($name, $gmapi, $data)
{
	if (empty($gmapi[$name]['download']) or empty($data[$name])) {
		return '';
	} else {
		return '<a class="btn btn-danger" href="' . sprintf($gmapi[$name]['download'], $data[$name]['version']) . '">Download <em>' . $gmapi[$name]['name'] . '</em> - <small>v</small>' . $data[$name]['version'] . ' directly</a>';
	}
}

function days_ago($time)
{
	$s = '';
    if ($time < 0) {
        return '- not yet ;)';
    }

	$d1 = new DateTime();
	$d2 = new DateTime();
	$d2->sub(new DateInterval(('P' . $time . 'D')));

	$diff = $d1->diff($d2);

    $s .= date('d/m/Y', $d2->getTimestamp()) . ', ';

    if ($time < 7) {
        if ($time == 0) {
            $s .= '<b>TODAY</b>';
        } else {
            if ($time == 1) {
                $s .= '<b>YESTERDAY</b>';
            } else {
                $s .= '<b>' . $time . ' days ago</b>';
            }
        }
        return $s . ' <span class="badge badge-warning">NEW!</span>';
    }

	$addDaysInBracket = false;

	if ($diff->y > 0) {
		$s .= $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ', ';
		//$addDaysInBracket = true;
	}

	if ($diff->m > 0) {
		$s .= $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ', ';
		//$addDaysInBracket = true;
	}

	$s .= $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . '';

	return '<b>' . $s . ' ago</b> ' . ($addDaysInBracket ? ('<sup>(' . $time . ' days)</sup>') : '');
}

/**
 * Input an object, returns a json-ized string of said object, pretty-printed
 *
 * @param mixed $obj The array or object to encode
 *
 * @return string JSON formatted output
 */
function json_encode_pretty($obj, $indentation = 0)
{
    switch (gettype($obj)) {
        case 'object':
            $obj = get_object_vars($obj);
        case 'array':
            if (!isset($obj[0])) {
                $arr_out = array();
                foreach ($obj as $key => $val) {
                    $arr_out[] = '"' . addslashes($key) . '": ' . json_encode_pretty($val, $indentation + 1);
                }
                /* if (count($arr_out) < 2) {
                  return '{' . implode(',', $arr_out) . '}';
                  } */
                return "{\n" . str_repeat("    ", $indentation + 1) . implode(
                    ",\n" . str_repeat("    ", $indentation + 1), $arr_out
                ) . "\n" . str_repeat("    ", $indentation) . "}";
            } else {
                $arr_out = array();
                $ct = count($obj);
                for ($j = 0; $j < $ct; $j++) {
                    $arr_out[] = json_encode_pretty($obj[$j], $indentation + 1);
                }
                if (count($arr_out) < 2) {
                    return '[' . implode(',', $arr_out) . ']';
                }
                return "[\n" . str_repeat("    ", $indentation + 1) . implode(
                    ",\n" . str_repeat("    ", $indentation + 1), $arr_out
                ) . "\n" . str_repeat("    ", $indentation) . "]";
            }
            break;
        case 'NULL':
            return 'null';
            break;
        case 'boolean':
            return $obj ? 'true' : 'false';
            break;
        case 'integer':
        case 'double':
            return $obj;
            break;
        case 'string':
        default:
            $obj = str_replace(array('\\', '"',), array('\\\\', '\"'), $obj);
            return '"' . $obj . '"';
            break;
    }
}
