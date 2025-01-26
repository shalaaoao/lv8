<?php

namespace App\Entity\Calc;

class TreeNode
{
    // 索引值
    public ?int $val;

    // 额外信息
    public array $extra;

    public ?TreeNode $left  = null;
    public ?TreeNode $right = null;

    // 查找用 - 父节点
    public static ?TreeNode $parentNodeTmp = null;

    // 查找用 - 父节点的方向
    public static string $parentDirectionTmp = '';

    // 扫到的全部父节点信息 子uuid => 父TreeNode
    public static array $parentNodes = [];

    public function __construct(?int $value, array $extra = [])
    {
        $this->val   = $value;
        $this->extra = $extra;
    }

    /**
     * 插入
     * @param TreeNode|null $root
     * @param int $val
     * @param array $extra
     * @return TreeNode
     */
    public function insert(?TreeNode $root, int $val, array $extra): TreeNode
    {
        // 如果根节点为空，直接插入 - 第一次的情况
        if ($this->val == null) {
            $this->val   = $val;
            $this->extra = $extra;
            return $this;
        }

        if ($root == null) {
            return new TreeNode($val, $extra);
        }

        if ($val < $root->val) {
            $root->left = $this->insert($root->left, $val, $extra);
        } else {
            $root->right = $this->insert($root->right, $val, $extra);
        }

        return $root;
    }

    /**
     * 查找第一个
     * @param int $val
     * @return TreeNode
     */
    public function findFirst(int $val): ?self
    {
        if ($this->val == $val) {

            self::$parentNodes[$this->extra['uuid']] = [
                'node'      => self::$parentNodeTmp,
                'direction' => self::$parentDirectionTmp
            ];

            return $this;
        } elseif ($val < $this->val) {

            // 记录父节点信息
            self::$parentNodeTmp      = $this;
            self::$parentDirectionTmp = 'left';

            return optional($this->left)->findFirst($val);
        } else {

            // 记录父节点信息
            self::$parentNodeTmp      = $this;
            self::$parentDirectionTmp = 'right';

            return optional($this->right)->findFirst($val);
        }
    }

    /**
     * 查找全部val的结果
     * @var array
     */
    private static array $findAllResult = [];

    /**
     * 查找
     * @param int $val
     * @return array
     */
    public function findAll(int $val): array
    {
        if ($this->val == $val) {

            self::$findAllResult[] = $this;

            self::$parentNodes[$this->extra['uuid']] = [
                'node'      => self::$parentNodeTmp,
                'direction' => self::$parentDirectionTmp
            ];

            // 如果还有右节点
            if ($this->right !== null) {

                self::$parentNodeTmp      = $this;
                self::$parentDirectionTmp = 'right';

                return $this->right->findAll($val);
            }

            return self::$findAllResult;

        } elseif ($val < $this->val) {

            self::$parentNodeTmp      = $this;
            self::$parentDirectionTmp = 'left';

            if ($this->left === null) {
                return self::$findAllResult;
            }

            return optional($this->left)->findAll($val);
        } else {

            self::$parentNodeTmp      = $this;
            self::$parentDirectionTmp = 'right';

            if ($this->right === null) {
                return self::$findAllResult;
            }

            return optional($this->right)->findAll($val);
        }
    }

    /**
     * 查找最小值
     * @param TreeNode $treeNode
     * @return TreeNode
     */
    public function findMin(TreeNode $treeNode): self
    {
        if ($treeNode->left === null) {

            self::$parentNodes[$treeNode->extra['uuid']] = [
                'node'      => self::$parentNodeTmp,
                'direction' => self::$parentDirectionTmp
            ];

            return $treeNode;
        }

        // 记录父节点信息
        self::$parentNodeTmp      = $treeNode;
        self::$parentDirectionTmp = 'left';

        return $this->findMin($treeNode->left);
    }

    /**
     * 删除第一个
     * @param int $val
     * @return $this
     */
    public function deleteFirst(int $val): self
    {
        // TODO 删除根节点 pNode可能存在取不到报错

        // 先找到这个节点
        $node = $this->findFirst($val);
        if ($node == null) {
            return $this;
        }

        // 1. 如果要删除的节点没有子节点，只需要直接将父节点中，指向要删除节点的指针置为null
        if ($node->left == null && $node->right == null) {

            // 父节点
            $pNode      = self::$parentNodes[$node->extra['uuid']]['node'];
            $pDirection = self::$parentNodes[$node->extra['uuid']]['direction'];

            $pNode->{$pDirection} = null;

            return $this;
        }

        // 2. 如果要删除的节点只有一个子节点，只需要更新父节点中，指向要删除节点的指针指向要删除节点的子节点
        if ($node->left == null || $node->right == null) {

            // 父节点
            $pNode      = self::$parentNodes[$node->extra['uuid']]['node'];
            $pDirection = self::$parentNodes[$node->extra['uuid']]['direction'];

            $pNode->{$pDirection} = $node->left ?? $node->right;

            return $this;
        }

        // 3. 如果要删除的节点有两个子节点，需要找到右子树中的最小节点，将其值赋给要删除的节点，然后删除右子树中的最小节点

        // 找到右子树中的最小节点
        $minNode     = $this->findMin($node->right);
        $node->val   = $minNode->val;
        $node->extra = $minNode->extra;

        // 删除右子树中的最小节点
        $pNode      = self::$parentNodes[$node->extra['uuid']]['node'];
        $pDirection = self::$parentNodes[$node->extra['uuid']]['direction'];

        $pNode->{$pDirection} = null;

        return $this;
    }

    /**
     * 删除全部val值的节点
     * @param int $val
     */
    public function deleteAll(int $val): self
    {
        $nodes = $this->findAll($val);

        // 数组倒序 - 先删除下面的节点
        $nodes = array_reverse($nodes);

        foreach ($nodes as $node) {

            // 1. 如果要删除的节点没有子节点，只需要直接将父节点中，指向要删除节点的指针置为null
            if ($node->left == null && $node->right == null) {

                // 父节点
                $pNode      = self::$parentNodes[$node->extra['uuid']]['node'];
                $pDirection = self::$parentNodes[$node->extra['uuid']]['direction'];

                $pNode->{$pDirection} = null;

                continue;
            }

            // 2. 如果要删除的节点只有一个子节点，只需要更新父节点中，指向要删除节点的指针指向要删除节点的子节点
            if ($node->left == null || $node->right == null) {

                // 父节点
                $pNode      = self::$parentNodes[$node->extra['uuid']]['node'];
                $pDirection = self::$parentNodes[$node->extra['uuid']]['direction'];

                $pNode->{$pDirection} = $node->left ?? $node->right;

                continue;
            }

            // 3. 如果要删除的节点有两个子节点，需要找到右子树中的最小节点，将其值赋给要删除的节点，然后删除右子树中的最小节点

            // 找到右子树中的最小节点
            $minNode     = $this->findMin($node->right);
            $node->val   = $minNode->val;
            $node->extra = $minNode->extra;

            // 删除右子树中的最小节点
            $pNode      = self::$parentNodes[$node->extra['uuid']]['node'];
            $pDirection = self::$parentNodes[$node->extra['uuid']]['direction'];

            $pNode->{$pDirection} = null;

            continue;
        }

        return $this;
    }

    /**
     * 排序的结果
     * @var array
     */
    public array $orderResult = [];

    /**
     * 前序遍历
     * 对于树中的任意节点来说，先打印这个节点，然后再打印它的左子树，最后打印它的右子树。
     */
    public function preOrder(?TreeNode $treeNode, bool $init = false): void
    {
        if ($init) {
            $this->orderResult = [];
        }

        if ($treeNode == null) {
            return;
        }

        $this->orderResult[] = $treeNode->val;
        $this->preOrder($treeNode->left);
        $this->preOrder($treeNode->right);
    }

    /**
     * 中序遍历
     * 对于树中的任意节点来说，先打印它的左子树，然后再打印这个节点，最后打印它的右子树。
     * 可以输出有序的结果
     */
    public function inOrder(?TreeNode $treeNode, bool $init = false): void
    {
        if ($init) {
            $this->orderResult = [];
        }

        if ($treeNode == null) {
            return;
        }

        $this->inOrder($treeNode->left);
        $this->orderResult[] = $treeNode->val;
        $this->inOrder($treeNode->right);
    }

    /**
     * 后序遍历
     * 对于树中的任意节点来说，先打印它的左子树，然后再打印它的右子树，最后打印这个节点。
     */
    public function postOrder(?TreeNode $treeNode, bool $init = false): void
    {
        if ($init) {
            $this->orderResult = [];
        }

        if ($treeNode == null) {
            return;
        }

        $this->postOrder($treeNode->left);
        $this->postOrder($treeNode->right);
        $this->orderResult[] = $treeNode->val;
    }

    /**
     * 生成树的html
     * @param TreeNode|null $treeNode
     * @return string
     */
    public function generateTreeHtml(?TreeNode $treeNode): string
    {
        if ($treeNode == null) {
            return '<li><a class="ball">&nbsp&nbsp</a></li>';
        }

        $html = '<li><a class="ball">' . $treeNode->val . '</a>';

        if ($treeNode->left !== null || $treeNode->right !== null) {
            $html .= '<ul>';
            $html .= $this->generateTreeHtml($treeNode->left);
            $html .= $this->generateTreeHtml($treeNode->right);
            $html .= '</ul>';
        }

        $html .= '</li>';

        return $html;
    }
}
