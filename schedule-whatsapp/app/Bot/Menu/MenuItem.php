<?php

namespace App\Bot\Menu;

/**
 * Classe MenuItem
 * 
 * Representa um item de menu individual (Leaf no padrão Composite).
 * Um MenuItem não pode ter componentes filhos.
 */
class MenuItem implements MenuComponent
{
    /**
     * @var string|int O identificador do item
     */
    protected $id;
    
    /**
     * @var string O texto a ser exibido para o usuário
     */
    protected $text;
    
    /**
     * @var string O tipo de ação a ser executada quando este item for selecionado
     */
    protected $actionType;
    
    /**
     * @var mixed Os dados associados à ação
     */
    protected $actionData;
    
    /**
     * Cria um novo item de menu.
     *
     * @param string|int $id O identificador do item
     * @param string $text O texto a ser exibido
     * @param string $actionType O tipo de ação (ex: 'service', 'schedule', 'message')
     * @param mixed $actionData Os dados da ação
     */
    public function __construct($id, string $text, string $actionType, $actionData = null)
    {
        $this->id = $id;
        $this->text = $text;
        $this->actionType = $actionType;
        $this->actionData = $actionData;
    }
    
    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @inheritDoc
     */
    public function getText()
    {
        return $this->text;
    }
    
    /**
     * Retorna o tipo de ação.
     *
     * @return string
     */
    public function getActionType(): string
    {
        return $this->actionType;
    }
    
    /**
     * Retorna os dados da ação.
     *
     * @return mixed
     */
    public function getActionData()
    {
        return $this->actionData;
    }
    
    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return $this->text;
    }
    
    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'type' => 'item',
            'id' => $this->id,
            'text' => $this->text,
            'actionType' => $this->actionType,
            'actionData' => $this->actionData,
        ];
    }
    
    /**
     * @inheritDoc
     */
    public function handlesInput(string $input): bool
    {
        // Um MenuItem manipula a entrada se ela corresponder exatamente ao ID do item
        // ou ao texto (insensível a maiúsculas/minúsculas)
        return (string)$this->id === $input || 
               strtolower($this->text) === strtolower($input);
    }
    
    /**
     * @inheritDoc
     */
    public function processInput(string $input)
    {
        if (!$this->handlesInput($input)) {
            return null;
        }
        
        // Retorna a ação e os dados para processamento posterior
        return [
            'actionType' => $this->actionType,
            'actionData' => $this->actionData,
        ];
    }
}