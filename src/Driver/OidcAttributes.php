<?php

namespace StuRaBtu\Oidc\Driver;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use LightSaml\Model\Assertion\Attribute;

class OidcAttributes
{
    /**
     * The BTU identifier suffix which is append to the samlSubjectID
     */
    public const BTU_ID_SUFFIX = '@b-tu.de';

    /**
     * The OIDC user attributes.
     *
     * @param  array<string,string|string[]>  $attributes
     */
    public function __construct(
        protected array $attributes
    ) {}

    /**
     * Map the OIDC user attributes to the Application User attributes
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return [
            'btu_id' => $this->asBtuIdentifier('preferred_username'),
            'name' => $this->asString('name'),
            'groups' => $this->asArray('groups'),
        ];
    }

    /**
     * Transform a OIDC user attribute to an array.
     *
     * @return null|array<string>
     */
    public function asArray(string $attribute): ?array
    {
        return $this->attributes[$attribute] ?? null;
    }

    /**
     * Transform a OIDC user attribute to a string.
     */
    public function asString(string $attribute): ?string
    {
        return $this->attributes[$attribute] ?? null;
    }

    /**
     * Transform a OIDC user attribute to a date.
     */
    public function asDate(string $attribute): ?Carbon
    {
        $value = $this->asString($attribute);

        if ($value === null) {
            return null;
        }

        return Carbon::createFromFormat('Ymd', $value);
    }

    /**
     * Transform a OIDC user attribute to a date.
     */
    public function asBtuIdentifier(string $attribute): string
    {
        $value = $this->asString($attribute);

        if ($value === null) {
            throw new \InvalidArgumentException("Attribute {$attribute} is required to extract BTU identifier");
        }

        return Str::before($value, self::BTU_ID_SUFFIX);
    }
}
