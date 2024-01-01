<?php
namespace App\Services\Shipping;

use InvalidArgumentException;

class PackageDimension{
  public function __construct(
    public readonly int $width, 
    public readonly int $height,
    public readonly int $length)
  {
    match (true) {
      $this->width  <= 0 || $this->width > 80   => throw new InvalidArgumentException('Invalid Package width'),
      $this->height <= 0 || $this->height > 80  => throw new InvalidArgumentException('Invalid Package height'),
      $this->length <= 0 || $this->length > 80  => throw new InvalidArgumentException('Invalid Package length'),
      default => true,
    };
  }

  public function increaseWidth(int $width): self{
    return new self($this->width += $width, $this->height, $this->length);
  }

  public function equalTo(PackageDimension $other){
    return 
      $this->width == $other->width && 
      $this->height == $other->height && 
      $this->length == $other->length;
  }
} 