<?php

namespace Smoren\GraphTools\Structs;

use Smoren\GraphTools\Models\Interfaces\EdgeInterface;
use Smoren\GraphTools\Models\Interfaces\VertexInterface;
use Smoren\GraphTools\Structs\Interfaces\TraverseBranchContextInterface;
use Smoren\GraphTools\Structs\Interfaces\TraverseContextInterface;

class TraverseContext implements TraverseContextInterface
{
    /**
     * @var VertexInterface
     */
    protected VertexInterface $vertex;
    /**
     * @var EdgeInterface|null
     */
    protected ?EdgeInterface $edge;
    /**
     * @var TraverseBranchContextInterface
     */
    protected TraverseBranchContextInterface $branchContext;
    /**
     * @var array<string, VertexInterface>
     */
    protected array $passedVertexesMap;
    /**
     * @var array<string, VertexInterface>
     */
    protected array $globalPassedVertexesMap;

    /**
     * @param VertexInterface $vertex
     * @param EdgeInterface|null $edge
     * @param TraverseBranchContextInterface $branchContext
     * @param array<string, VertexInterface> $passedVertexesMap
     * @param array<string, VertexInterface> $globalPassedVertexesMap
     */
    public function __construct(
        VertexInterface $vertex,
        ?EdgeInterface $edge,
        TraverseBranchContextInterface $branchContext,
        array $passedVertexesMap,
        array &$globalPassedVertexesMap
    ) {
        $this->vertex = $vertex;
        $this->edge = $edge;
        $this->branchContext = $branchContext;
        $this->passedVertexesMap = $passedVertexesMap;
        $this->globalPassedVertexesMap = &$globalPassedVertexesMap;
    }

    /**
     * @inheritDoc
     */
    public function getVertex(): VertexInterface
    {
        return $this->vertex;
    }

    /**
     * @return VertexInterface|null
     */
    public function getPrevVertex(): ?VertexInterface
    {
        $candidate = end($this->passedVertexesMap);
        return $candidate ?: null;
    }

    /**
     * @return EdgeInterface|null
     */
    public function getEdge(): ?EdgeInterface
    {
        return $this->edge;
    }

    /**
     * @inheritDoc
     */
    public function getBranchContext(): TraverseBranchContextInterface
    {
        return $this->branchContext;
    }

    /**
     * @inheritDoc
     */
    public function getPassedVertexesMap(): array
    {
        return $this->passedVertexesMap;
    }

    /**
     * @inheritDoc
     */
    public function getGlobalPassedVertexesMap(): array
    {
        return $this->globalPassedVertexesMap;
    }

    /**
     * @inheritDoc
     */
    public function isLoop(): bool
    {
        return isset($this->passedVertexesMap[$this->vertex->getId()]);
    }
}
