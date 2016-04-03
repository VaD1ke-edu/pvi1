<?php
namespace App\Bot;

/**
 * Command interface
 *
 * @category   App
 * @package    App
 * @subpackage Bot
 * @author     Vladislav Slesarenko <vladislav.slesarenko@gmail.com>
 */
interface ICommand
{
    /**
     * Execute command
     *
     * @param array $update Update
     *
     * @return void
     */
    public function execute(array $update);
}
