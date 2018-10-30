<?php

namespace Phpro\SoapClient\Soap;

use Phpro\SoapClient\Soap\ClassMap\ClassMapCollection;
use Phpro\SoapClient\Soap\TypeConverter\TypeConverterCollection;
// Alias the SoapClient to prevent issues with phpvcr code overriding
use Phpro\SoapClient\Soap\SoapClient as PhproSoapClient;

/**
 * Class SoapClientFactory
 *
 * @package Phpro\SoapClient\Soap
 */
class SoapClientFactory
{

    /**
     * @var ClassMapCollection
     */
    private $classMap;

    /**
     * @var TypeConverterCollection
     */
    private $typeConverters;

    /**
     * @param ClassMapCollection      $classMap
     * @param TypeConverterCollection $typeConverters
     */
    public function __construct(ClassMapCollection $classMap, TypeConverterCollection $typeConverters)
    {
        $this->classMap = $classMap;
        $this->typeConverters = $typeConverters;
    }

    /**
     * @param string $wsdl
     * @param array $soapOptions
     *
     * @return SoapClient
     */
    public function factory(string $wsdl, array $soapOptions = []): SoapClient
    {
        $defaults = [
            'trace' => true,
            'exceptions' => true,
            'keep_alive' => true,
            'cache_wsdl' => WSDL_CACHE_DISK,
            'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
            'classmap' => $this->classMap->toSoapClassMap(),
            'typemap' => $this->typeConverters->toSoapTypeMap(),
        ];

        $options = array_merge($defaults, $soapOptions);

        return new PhproSoapClient($wsdl, $options);
    }
}
