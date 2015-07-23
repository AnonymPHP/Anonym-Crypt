<?php
    /**
     * Bu Dosya AnonymFramework'e ait bir dosyadır.
     *
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @see http://gemframework.com
     *
     */

    namespace Anonym\Components\Crypt;
    use Exception;
    use InvalidArgumentException;
    use Anonym\Components\Crypt\CrypterEncodeableInterface;
    use Anonym\Components\Crypt\CrypterDecodeableInterface;
    /**
     * Class AnonymCrypt
     * @package Anonym\Components\Crypt
     */
    class AnonymCrypt implements CrypterDecodeableInterface,CrypterEncodeableInterface
    {

        /**
         * Güvenlik anahtarı
         *
         * @var string
         */
        private $securityKey;
        /**
         * Mcrypt şifreleme türü
         *
         * @var string
         */
        private $mode = MCRYPT_MODE_ECB;

        /**
         * Mcrypt şifreleme rastgele sayısı
         *
         * @var int
         */
        private $rand = MCRYPT_RAND;
        /**
         * Mcrypt Şifreleme aligoritması
         *
         * @var string
         */
        private $alogirtym = MCRYPT_RIJNDAEL_256;

        /**
         * Sınıfı başlatır
         *
         * @throws Exception
         */
        public function __construct()
        {
            if (!extension_loaded('mcrypt')) {
                throw new Exception('Sunucunuzda Mcrypt desteği bulunamadı.');
            }

            $this->setSecurityKey('AnonymCrypter');
        }
        /**
         * Şifrelenmiş metni oluşturur
         *
         * @param string $value
         * @return string
         * @return mixed
         */
        public function encode($value = '')
        {
            if (is_string($value)) {
                $iv = mcrypt_create_iv($this->getIvSize(), $this->getRandomizer());
                $base = base64_encode(json_encode($this->payloadCreator($this->encrypt($value, $iv), $iv)));
                return $base;
            }
        }
        /**
         * @param string $value
         * @param        $iv
         * @return string
         * Şifrelenmiş metni hazırlar
         */
        private function encrypt($value = '', $iv)
        {
            $value = $this->returnCleanAndHexedValue($value);
            try {
                $crypted = mcrypt_encrypt($this->alogirtym, $this->securityKey, $value, $this->mode, $iv);
                return $crypted;
            } catch (Exception $e) {
                //
            }
        }
        /**
         * Value ve iv değerlerini kullanılmak için hazırlar
         *
         * @param $creypted
         * @param $iv
         * @return array
         */
        private function payloadCreator($creypted, $iv)
        {
            return [
                'value' => base64_encode($creypted),
                'iv'    => base64_encode($iv),
            ];
        }
        /**
         * Temizlenmiş value değeri oluşturur
         *
         * @param string $value
         * @return string
         */
        private function returnCleanAndHexedValue($value = '')
        {
            $value = trim($value);
            return $value;
        }
        /**
         * Randomizer i döndürür
         *
         * @return int
         */
        private function getRandomizer()
        {
            if ($this->getRand()) {
                return $this->getRand();
            }
        }
        /**
         * Iv uzunluÄŸunu DÃ¶ndÃ¼rÃ¼r
         *
         * @return int
         */
        private function getIvSize()
        {
            return mcrypt_get_iv_size($this->getAlogirtym(), $this->getMode());
        }

        /**
         * Şifrelenmiş metni çözer
         *
         * @param string $value
         * @return string
         */
        public function decode($value = '')
        {

            if (is_string($value)) {
                $payload = $this->parsePayload($value);
                return $this->decrypt($payload);
            }
        }
        /**
         * @param $value
         * @return array
         * payload verisi parçalanır
         */
        private function parsePayload($value)
        {
            $based = (array)json_decode(base64_decode($value));
            if (isset($based['value']) && isset($based['iv'])) {
                return [
                    'value' => base64_decode($based['value']),
                    'iv'    => base64_decode($based['iv'])
                ];
            }
        }
        /**
         * Metnin şifresini çözer
         *
         * @param array $payload
         * @return string
         */
        private function decrypt(array $payload)
        {
            $iv = $payload['iv'];
            $value = $payload['value'];
            $value = $this->returnCleanAndDeHexedValue($value);
            return mcrypt_decrypt($this->getAlogirtym(), $this->getSecurityKey(), $value, $this->getMode(), $iv);
        }
        /**
         * @param $value
         * @return string
         * Parametreyi temizler ve hexden çıkarır
         */
        private function returnCleanAndDeHexedValue($value)
        {
            $value = trim($value);
            return $value;
        }

        /**
         * @return mixed
         */
        public function getSecurityKey()
        {
            return $this->securityKey;
        }

        /**
         * @param mixed $securityKey
         * @throws InvalidArgumentException
         * @return AnonymCrypt
         */
        public function setSecurityKey($securityKey)
        {

            if($securityKey instanceof SecurityKeyGeneratorInterface){
                $securityKey = $securityKey->create();
            }

            if(!is_string($securityKey)){
                throw new InvalidArgumentException('Güvenlik anahtarınız sadece string olabilir');
            }
            $this->securityKey = $securityKey;
            return $this;
        }

        /**
         * @return string
         */
        public function getMode()
        {
            return $this->mode;
        }

        /**
         * @param string $mode
         * @return AnonymCrypt
         */
        public function setMode($mode)
        {
            $this->mode = $mode;

            return $this;
        }

        /**
         * @return int
         */
        public function getRand()
        {
            return $this->rand;
        }

        /**
         * @param int $rand
         * @return AnonymCrypt
         */
        public function setRand($rand)
        {
            $this->rand = $rand;

            return $this;
        }

        /**
         * @return string
         */
        public function getAlogirtym()
        {
            return $this->alogirtym;
        }

        /**
         * @param string $alogirtym
         * @return AnonymCrypt
         */
        public function setAlogirtym($alogirtym)
        {
            $this->alogirtym = $alogirtym;

            return $this;
        }

    }
