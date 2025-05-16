<?php

declare(strict_types=1);

namespace App\Restaurant\Infrastructure\Api\Controller\MenuItem;

use App\Restaurant\Core\Command\Internal\MenuItem\Create\CreateMenuItemCommand;
use App\Restaurant\Core\Command\Internal\MenuItem\MenuItemDto;
use App\Restaurant\Core\Command\Internal\MenuItem\Update\UpdateMenuItemCommand;
use App\Shared\Domain\Restaurant\MenuItemId;
use App\Shared\Infrastructure\Api\Request\PriceRequestDto;
use Symfony\Component\Validator\Constraints as Assert;

class MenuItemRequest
{
    public function __construct(
        #[Assert\Length(min: 1, max: 100)]
        public string $name,
        #[Assert\NotBlank]
        #[Assert\Valid]
        public PriceRequestDto $price,
    ) {
    }

    public function getCreateCommand(MenuItemId $id): CreateMenuItemCommand
    {
        return new CreateMenuItemCommand($this->getMenuItemDto($id));
    }

    public function getUpdateCommand(MenuItemId $id): UpdateMenuItemCommand
    {
        return new UpdateMenuItemCommand($this->getMenuItemDto($id));
    }

    private function getMenuItemDto(MenuItemId $id): MenuItemDto
    {
        return new MenuItemDto(
            $id,
            $this->name,
            $this->price->getVO(),
        );
    }
}
