<?php

namespace Gerar;

class Package
{
    function __construct($name)
    {
        $this->name = $name;
    }

    public static function named($name)
    {
        if(strstr($name, ' ')) {
            return new PackageList(explode(' ', $name));
        } else {
            return new Package($name);
        }
    }

    public function shouldBeInstalled()
    {
        if(!$this->isInstalled()) {
            $this->install();
        }
    }

    private function isInstalled()
    {
        if(ThisServer::isUbuntu()) {
            return Process::getReturnCode("dpkg -s '{$this->name}'") == 0;
        }
        Gerar::notImplemented();
    }

    private function install()
    {
        Console::log("Package {$this->name} will be installed");
        if(ThisServer::isUbuntu()) {
            Process::runAndCheckReturnCode("DEBIAN_FRONTEND=noninteractive apt-get install -y {$this->name}");
            return $this;
        }
        Gerar::notImplemented();
    }
}