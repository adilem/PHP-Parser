<?php declare(strict_types=1);

namespace PhpParser;

class CommentTest extends \PHPUnit\Framework\TestCase {
    public function testGetters() {
        $comment = new Comment('/* Some comment */',
            1, 10, 2, 1, 27, 2);

        $this->assertSame('/* Some comment */', $comment->getText());
        $this->assertSame('/* Some comment */', (string) $comment);
        $this->assertSame(1, $comment->getLine());
        $this->assertSame(10, $comment->getFilePos());
        $this->assertSame(2, $comment->getTokenPos());
        $this->assertSame(1, $comment->getStartLine());
        $this->assertSame(10, $comment->getStartFilePos());
        $this->assertSame(2, $comment->getStartTokenPos());
        $this->assertSame(1, $comment->getEndLine());
        $this->assertSame(27, $comment->getEndFilePos());
        $this->assertSame(2, $comment->getEndTokenPos());
    }

    /**
     * @dataProvider provideTestReformatting
     */
    public function testReformatting($commentText, $reformattedText) {
        $comment = new Comment($commentText);
        $this->assertSame($reformattedText, $comment->getReformattedText());
    }

    public function provideTestReformatting() {
        return [
            ['// Some text', '// Some text'],
            ['/* Some text */', '/* Some text */'],
            [
                '/**
     * Some text.
     * Some more text.
     */',
                '/**
 * Some text.
 * Some more text.
 */'
            ],
            [
                '/*
        Some text.
        Some more text.
    */',
                '/*
    Some text.
    Some more text.
*/'
            ],
            [
                '/* Some text.
       More text.
       Even more text. */',
                '/* Some text.
   More text.
   Even more text. */'
            ],
            [
                '/* Some text.
       More text.
         Indented text. */',
                '/* Some text.
   More text.
     Indented text. */',
            ],
            // invalid comment -> no reformatting
            [
                'hallo
    world',
                'hallo
    world',
            ],
        ];
    }
}
