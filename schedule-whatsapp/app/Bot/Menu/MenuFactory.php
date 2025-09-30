<?php

namespace App\Bot\Menu;

/**
 * Classe MenuFactory
 * 
 * Factory para criar estruturas de menu a partir de JSON ou array.
 */
class MenuFactory
{
    /**
     * Cria uma estrutura de menu a partir de um array ou string JSON.
     *
     * @param array|string $data Os dados do menu (array ou JSON string)
     * @return Menu O menu raiz criado
     * @throws \InvalidArgumentException Se os dados forem inválidos
     */
    public static function createFromData($data): Menu
    {
        // Se for uma string JSON, converte para array
        if (is_string($data)) {
            $data = json_decode($data, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \InvalidArgumentException('JSON inválido fornecido para criação do menu');
            }
        }
        
        // Verifica se é um array válido
        if (!is_array($data) || !isset($data['type']) || $data['type'] !== 'menu') {
            throw new \InvalidArgumentException('Dados de menu inválidos');
        }
        
        return self::createMenuFromArray($data);
    }
    
    /**
     * Método recursivo para criar um Menu a partir de um array.
     *
     * @param array $data Os dados do menu
     * @return Menu
     * @throws \InvalidArgumentException Se os dados forem inválidos
     */
    protected static function createMenuFromArray(array $data): Menu
    {
        $menu = new Menu(
            $data['id'],
            $data['title'],
            $data['instructions'] ?? null
        );
        
        // Adiciona os componentes filhos
        if (isset($data['children']) && is_array($data['children'])) {
            foreach ($data['children'] as $childData) {
                if (!isset($childData['type'])) {
                    throw new \InvalidArgumentException('Tipo de componente não especificado');
                }
                
                if ($childData['type'] === 'menu') {
                    // Cria um submenu recursivamente
                    $submenu = self::createMenuFromArray($childData);
                    $menu->addComponent($submenu);
                } else if ($childData['type'] === 'item') {
                    // Cria um item de menu
                    $item = new MenuItem(
                        $childData['id'],
                        $childData['text'],
                        $childData['actionType'],
                        $childData['actionData'] ?? null
                    );
                    $menu->addComponent($item);
                } else {
                    throw new \InvalidArgumentException('Tipo de componente desconhecido: ' . $childData['type']);
                }
            }
        }
        
        return $menu;
    }
    
    /**
     * Cria uma estrutura de menu padrão básica para novos profissionais.
     *
     * @return Menu
     */
    public static function createDefaultMenu(): Menu
    {
        // Menu principal
        $mainMenu = new Menu('main', 'Menu Principal', 'Selecione uma opção:');
        
        // Adiciona itens ao menu principal
        $mainMenu->addComponent(new MenuItem('1', 'Ver Serviços', 'services_list'));
        $mainMenu->addComponent(new MenuItem('2', 'Agendar Atendimento', 'schedule'));
        $mainMenu->addComponent(new MenuItem('3', 'Meus Agendamentos', 'my_appointments'));
        
        // Submenu de informações
        $infoMenu = new Menu('info', 'Informações', 'O que você deseja saber?');
        $infoMenu->addComponent(new MenuItem('info_1', 'Horário de Funcionamento', 'hours'));
        $infoMenu->addComponent(new MenuItem('info_2', 'Localização', 'location'));
        $infoMenu->addComponent(new MenuItem('info_3', 'Formas de Pagamento', 'payment_methods'));
        
        // Adiciona o submenu ao menu principal
        $mainMenu->addComponent($infoMenu);
        
        return $mainMenu;
    }
}