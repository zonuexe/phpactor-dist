<?php

namespace Phpactor\Name;

use Countable;
interface Name extends Countable
{
    public function __toString() : string;
    public function toArray() : array;
    public function head() : \Phpactor\Name\QualifiedName;
    public function tail() : \Phpactor\Name\Name;
    public function isDescendantOf(\Phpactor\Name\Name $name) : bool;
    public function count() : int;
    public function prepend(\Phpactor\Name\Name $name) : \Phpactor\Name\Name;
    public function append(\Phpactor\Name\Name $name) : \Phpactor\Name\Name;
}
