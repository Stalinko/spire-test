<?php

class UspsApi
{
    private const ENDPOINT = 'https://secure.shippingapis.com/ShippingAPI.dll';

    public function __construct(
        private readonly HttpClient $client,
        private readonly string $user_id
    )
    {
    }

    public function verifyAddress(Address $address): string
    {
        $params = [
            'API' => 'Verify',
            'XML' => $this->formatXML($address),
        ];

        return $this->client->get(self::ENDPOINT, $params);
    }

    public function parseResponse(string $response): Address
    {
        $addresses = new SimpleXMLElement($response);
        if (empty($addresses->Address[0])) {
            throw new AddressVerificationError;
        }

        $address = $addresses->Address[0];

        if (!empty($address->Error[0]->Description[0])) {
            throw new AddressVerificationError($address->Error[0]->Description[0]);
        }

        $fields = [
            'address_line1' => $address->Address1[0] ?? '',
            'address_line2' => $address->Address2[0] ?? '',
            'city' => $address->City[0] ?? '',
            'state' => $address->State[0] ?? '',
            'zip' => $address->Zip5[0] ?? '',
        ];

        return new Address($fields);
    }

    private function formatXML(Address $address): string
    {
        return sprintf(<<<XML
<AddressValidateRequest USERID="$this->user_id">
    <Revision>1</Revision>
    <Address ID="0">
        <Address1>%s</Address1>
        <Address2>%s</Address2>
        <City>%s</City>
        <State>%s</State>
        <Zip5>%s</Zip5>
        <Zip4 />
    </Address>
</AddressValidateRequest>
XML,
            self::safe($address->getAddressLine1()),
            self::safe($address->getAddressLine2()),
            self::safe($address->getCity()),
            self::safe($address->getState()),
            self::safe($address->getZip()),
        );
    }

    private static function safe(string $s): string
    {
        return htmlspecialchars($s, ENT_XML1, 'UTF-8');
    }
}