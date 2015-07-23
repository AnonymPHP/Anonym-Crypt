<?php
    /**
     * Bu Dosya AnonymFramework'e ait bir dosyadır.
     *
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @see http://gemframework.com
     *
     */

    namespace Anonym\Components\Crypt;

    /**
     * Class Crypter
     * @package Anonym\Components\Crypt
     */
    class Crypter
    {

        /**
         * @var CrypterInterface
         */
        private $crypter;

        /**
         *  Sınııf başlatır ve şifreleyici olarak ön tanımlı olarak atananı kullanır
         *
         *
         */
        public function __construct()
        {
            $this->useDefaultCrypter();
        }

        /**
         * Default olarak AnonymCrypt sınıfı eklenir
         */
        private function useDefaultCrypter()
        {
            $this->setCrypter( new AnonymCrypt());
        }
        /**
         * Veriyi şifreler
         *
         * @param string $encode
         * @return string
         */
        public function encode($encode = ''){
            return $this->getCrypter()->encode($encode);
        }

        /**
         * Şifrelenmiş veriyi çözer
         *
         * @param string $decode
         * @return string
         */
        public function decode($decode = ''){
            return $this->getCrypter()->decode($decode);
        }

        /**
         * @return CrypterInterface
         */
        public function getCrypter()
        {
            return $this->crypter;
        }

        /**
         * @param CrypterInterface $crypter
         * @return Crypter
         */
        public function setCrypter($crypter)
        {
            $this->crypter = $crypter;

            return $this;
        }


    }