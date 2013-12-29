<?php
/*
 * This file is part of the Onema {OpsWorks} Package. 
 * For the full copyright and license information, 
 * please view the LICENSE file that was distributed 
 * with this source code.
 */
namespace Onema\OpsWOrksConsole\Exception;

/**
 * CommandException - Description. 
 *
 * @author Juan Manuel Torres <kinojman@gmail.com>
 * @copyright (c) 2013, onema.io
 */
interface CommandExceptionInterface
{
    public function getCode();
    public function getLine();
    public function getFile();
    public function getMessage();
    public function getPrevious();
    public function getTrace();
}