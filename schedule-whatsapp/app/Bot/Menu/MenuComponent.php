<?php

namespace App\Bot\Menu;

/**
 * Interface MenuComponent
 * 
 * Interface base para todos os componentes do menu do bot.
 * Implementa o padrão de design Composite para estrutura de menus.
 */
interface MenuComponent
{
    /**
     * Retorna o identificador do componente do menu.
     *
     * @return string|int
     */
    public function getId();
    
    /**
     * Retorna o texto de exibição do componente do menu.
     *
     * @return string
     */
    public function getText();
    
    /**
     * Formata o componente para exibição ao usuário no WhatsApp.
     *
     * @return string
     */
    public function display(): string;
    
    /**
     * Converte o componente para um array para armazenamento JSON.
     *
     * @return array
     */
    public function toArray(): array;
    
    /**
     * Verifica se este componente manipula a entrada do usuário especificada.
     *
     * @param string $input A entrada do usuário
     * @return bool
     */
    public function handlesInput(string $input): bool;
    
    /**
     * Processa a entrada do usuário e retorna o próximo componente ou ação.
     *
     * @param string $input A entrada do usuário
     * @return mixed O resultado do processamento da entrada
     */
    public function processInput(string $input);
}