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
     * Interface CrypterInterface
     * @package Anonym\Components\Crypt
     */
    interface CrypterInterface
    {

        /**
         * Veriyi şifreler
         *
         * @param string $value
         * @return string
         */
        public function encode($value = '');

        /**
         * Şifrelenmiş metni çözer
         *
         * @param string $value
         * @return string
         */
        public function decode($value = '');
    }
