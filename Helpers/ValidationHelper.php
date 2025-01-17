<?php

namespace Helpers;

class ValidationHelper
{
    public static function integer($value, float $min = -INF, float $max = INF): int
    {
        // PHPには、データを検証する組み込み関数があります。詳細は https://www.php.net/manual/en/filter.filters.validate.php を参照ください。
        $value = filter_var($value, FILTER_VALIDATE_INT, ["min_range" => (int) $min, "max_range"=>(int) $max]);

        // 結果がfalseの場合、フィルターは失敗したことになります。
        if ($value === false) throw new \InvalidArgumentException("The provided value is not a valid integer.");

        // 値がすべてのチェックをパスしたら、そのまま返します。
        return $value;
    }

    public static function type(?string $type): string {
        if($type === null) throw new \InvalidArgumentException("The provided value is null.");

        $availableTypeList = ['cpu', 'gpu', 'motherboard', 'power', 'memory', 'ssd', 'hd'];

        // If provided value extis in availableTypeList, Keep the original $type value.
        // If provided value does not extis in availableTypeList, Set to false.
        $type = strtolower($type);
        $type = in_array($type, $availableTypeList, true) ? $type : false;
        if($type === false) throw new \InvalidArgumentException("The provided value is not a valid type.");

        return $type;
    }

    public static function order(string $order): string {

        $order = strtoupper($order);
        $orderList = ['ASC', 'DESC'];
        $order = in_array($order, $orderList, true) ? $order : false;
        if($order === false) throw new \InvalidArgumentException('The provided value is not a valid order.');

        return $order;
    }

    public static function string($value): string {
        $value = is_string($value) ? $value : false;

        if($value == false) throw new \InvalidArgumentException("The provided value is not a valid string.");

        return $value;
    }

    public static function snippet(array $data): array {
        if(!isset($data['snippet'])) {
            ValidationHelper::string($data['snippet']) ? $data['snippet'] : false;
        }

        if(!isset($data['password'])) {
            ValidationHelper::string($data['password']) ? $data['password'] : false;
        }
        
        ValidationHelper::expiration($data['pasteExpiration']);
        ValidationHelper::syntaxHighlight($data['syntaxHighlighting']);
         
        return $data;
    }

    public static function expiration(string $expiration): void {
        $expirationList = ['never', 'ten-minutes', 'one-hour', 'one-day'];
        $pasteExpiration = in_array($expiration, $expirationList) ? $expiration : false;
        if($pasteExpiration === false) throw new \InvalidArgumentException('PasteExpiration is not correct.');
    }

    public static function syntaxHighlight(string $syntaxHighlight): void {
        $highlightList = ['none', 'javascript', 'php', 'java', 'c', 'ruby', 'python'];
        $syntaxHighlighting = in_array($syntaxHighlight, $highlightList) ? $syntaxHighlight : false;
        if($syntaxHighlighting === false) throw new \InvalidArgumentException('SyntaxHighlighting is not correct');
    }
}