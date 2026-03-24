<?php


namespace app\forms\validators;

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Throwable;
use yii\validators\Validator;

class PhoneNumberValidator extends Validator
{
    public function validateAttribute($model, $attribute): void
    {
        if (empty($model->{$attribute})) {
            return;
        }

        try {
            if (!str_starts_with($model->{$attribute}, '+')) {
                $model->{$attribute} = '+' . $model->{$attribute};
            }
            $phoneUtil = PhoneNumberUtil::getInstance();
            $parsedNumber = $phoneUtil->parse($model->{$attribute});
            if (!$phoneUtil->isPossibleNumber($parsedNumber) && !$phoneUtil->isValidNumber($parsedNumber)) {
                $this->addError(
                    $model,
                    $attribute,
                    'Invalid phone number format'
                );
                return;
            }
            // Изменяем формат на формат без лишних символов
            $model->{$attribute} = $phoneUtil->format($parsedNumber, PhoneNumberFormat::E164);
        } catch (Throwable) {
            $this->addError(
                $model,
                $attribute,
                'Invalid phone number format'
            );
        }
    }

    public static function isValidPhoneNumber(string $phoneNumber): bool
    {
        try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $parsedNumber = $phoneUtil->parse($phoneNumber);
            if (!$phoneUtil->isPossibleNumber($parsedNumber) && !$phoneUtil->isValidNumber($parsedNumber)) {
                return false;
            }
            return true;
        } catch (Throwable) {
            return false;
        }
    }
}
