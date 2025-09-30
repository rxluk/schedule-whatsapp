<?php

namespace App\Bot\Menu;

/**
 * Classe Menu
 * 
 * Representa um menu que pode conter outros itens de menu ou submenus (Composite no padrão Composite).
 */
class Menu implements MenuComponent
{
    /**
     * @var string|int O identificador do menu
     */
    protected $id;
    
    /**
     * @var string O título do menu
     */
    protected $title;
    
    /**
     * @var string Texto de instruções opcional para o usuário
     */
    protected $instructions;
    
    /**
     * @var array Array de componentes filhos (MenuItem ou Menu)
     */
    protected $children = [];
    
    /**
     * @var MenuComponent|null O menu pai, se este for um submenu
     */
    protected $parent = null;
    
    /**
     * Cria um novo menu.
     *
     * @param string|int $id O identificador do menu
     * @param string $title O título do menu
     * @param string|null $instructions Instruções opcionais para o usuário
     */
    public function __construct($id, string $title, ?string $instructions = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->instructions = $instructions;
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
        return $this->title;
    }
    
    /**
     * Adiciona um componente filho (item ou submenu) a este menu.
     *
     * @param MenuComponent $component O componente a adicionar
     * @return self
     */
    public function addComponent(MenuComponent $component): self
    {
        $this->children[] = $component;
        
        // Se estamos adicionando um submenu, definimos este menu como o pai
        if ($component instanceof Menu) {
            $component->setParent($this);
        }
        
        return $this;
    }
    
    /**
     * Define o menu pai.
     *
     * @param Menu $parent O menu pai
     * @return self
     */
    public function setParent(Menu $parent): self
    {
        $this->parent = $parent;
        return $this;
    }
    
    /**
     * Retorna o menu pai.
     *
     * @return Menu|null
     */
    public function getParent(): ?Menu
    {
        return $this->parent;
    }
    
    /**
     * Verifica se este menu é o menu raiz (não tem pai).
     *
     * @return bool
     */
    public function isRoot(): bool
    {
        return $this->parent === null;
    }
    
    /**
     * Retorna todos os componentes filhos deste menu.
     *
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }
    
    /**
     * Obtém um componente filho pelo ID.
     *
     * @param string|int $id O ID do componente a encontrar
     * @return MenuComponent|null O componente se encontrado, null caso contrário
     */
    public function getComponentById($id): ?MenuComponent
    {
        foreach ($this->children as $child) {
            if ($child->getId() == $id) {
                return $child;
            }
            
            // Se for um submenu, procura recursivamente
            if ($child instanceof Menu) {
                $result = $child->getComponentById($id);
                if ($result !== null) {
                    return $result;
                }
            }
        }
        
        return null;
    }
    
    /**
     * @inheritDoc
     */
    public function display(): string
    {
        $output = $this->title . "\n\n";
        
        if ($this->instructions) {
            $output .= $this->instructions . "\n\n";
        }
        
        foreach ($this->children as $index => $child) {
            $optionNumber = $index + 1;
            $output .= "{$optionNumber}. " . $child->getText() . "\n";
        }
        
        if (!$this->isRoot()) {
            $output .= "\n0. Voltar";
        }
        
        return $output;
    }
    
    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $childrenArray = [];
        foreach ($this->children as $child) {
            $childrenArray[] = $child->toArray();
        }
        
        return [
            'type' => 'menu',
            'id' => $this->id,
            'title' => $this->title,
            'instructions' => $this->instructions,
            'children' => $childrenArray,
        ];
    }
    
    /**
     * @inheritDoc
     */
    public function handlesInput(string $input): bool
    {
        // Verifica se é um número correspondente a um item de menu
        if (is_numeric($input)) {
            $index = (int)$input - 1;
            
            // Opção "0" para voltar se não for o menu raiz
            if ($input === '0' && !$this->isRoot()) {
                return true;
            }
            
            // Verifica se o índice está dentro do intervalo de filhos
            return $index >= 0 && $index < count($this->children);
        }
        
        // Verifica se algum dos filhos lida diretamente com esta entrada
        foreach ($this->children as $child) {
            if ($child->handlesInput($input)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * @inheritDoc
     */
    public function processInput(string $input)
    {
        // Opção "0" para voltar ao menu pai
        if ($input === '0' && !$this->isRoot()) {
            return $this->parent;
        }
        
        // Se for um número, tenta acessar o item correspondente
        if (is_numeric($input)) {
            $index = (int)$input - 1;
            
            if ($index >= 0 && $index < count($this->children)) {
                $component = $this->children[$index];
                
                // Se for um submenu, retorna o submenu para navegação
                if ($component instanceof Menu) {
                    return $component;
                }
                
                // Se for um item, processa a entrada
                return $component->processInput($component->getText());
            }
        }
        
        // Procura por um filho que possa processar esta entrada diretamente
        foreach ($this->children as $child) {
            if ($child->handlesInput($input)) {
                return $child->processInput($input);
            }
        }
        
        return null;
    }
}