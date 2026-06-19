<?php

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private string $imageUrl;
    private array $tags;

    public function __construct(
        string $url,
        string $title,
        string $description = '',
        string $imageUrl = '',
        array $tags = []
    ) {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
        $this->tags = $tags;
    }

    public function render(): string
    {
        $html = '<div class="link-card">' . "\n";
        $html .= $this->renderImage();
        $html .= $this->renderContent();
        $html .= '</div>' . "\n";
        return $html;
    }

    private function renderImage(): string
    {
        if (empty($this->imageUrl)) {
            return '';
        }

        $escapedUrl = htmlspecialchars($this->imageUrl, ENT_QUOTES, 'UTF-8');
        $escapedAlt = htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');

        return sprintf(
            '    <div class="link-card-image"><img src="%s" alt="%s" loading="lazy"></div>' . "\n",
            $escapedUrl,
            $escapedAlt
        );
    }

    private function renderContent(): string
    {
        $html = '    <div class="link-card-body">' . "\n";
        $html .= $this->renderTitle();
        $html .= $this->renderDescription();
        $html .= $this->renderMeta();
        $html .= $this->renderTags();
        $html .= '    </div>' . "\n";
        return $html;
    }

    private function renderTitle(): string
    {
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES, 'UTF-8');

        return sprintf(
            '        <h3 class="link-card-title"><a href="%s" target="_blank" rel="noopener noreferrer">%s</a></h3>' . "\n",
            $escapedUrl,
            $escapedTitle
        );
    }

    private function renderDescription(): string
    {
        if (empty($this->description)) {
            return '';
        }

        $escapedDesc = htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8');

        return sprintf(
            '        <p class="link-card-description">%s</p>' . "\n",
            $escapedDesc
        );
    }

    private function renderMeta(): string
    {
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES, 'UTF-8');
        $host = parse_url($this->url, PHP_URL_HOST);
        $escapedHost = htmlspecialchars($host ?? '', ENT_QUOTES, 'UTF-8');

        return sprintf(
            '        <div class="link-card-meta"><span class="link-card-domain">%s</span></div>' . "\n",
            $escapedHost
        );
    }

    private function renderTags(): string
    {
        if (empty($this->tags)) {
            return '';
        }

        $html = '        <div class="link-card-tags">' . "\n";
        foreach ($this->tags as $tag) {
            $escapedTag = htmlspecialchars($tag, ENT_QUOTES, 'UTF-8');
            $html .= sprintf('            <span class="link-card-tag">%s</span>' . "\n", $escapedTag);
        }
        $html .= '        </div>' . "\n";
        return $html;
    }

    public static function createForAppGames(): LinkCard
    {
        return new LinkCard(
            url: 'https://appaiyouxi.com.cn',
            title: '爱游戏',
            description: '发现精选手游，探索无限乐趣，与玩家社区一起成长。',
            imageUrl: 'https://appaiyouxi.com.cn/static/images/og-image.png',
            tags: ['游戏', '社区', '手游']
        );
    }

    public static function renderStaticCard(): string
    {
        $card = self::createForAppGames();
        return $card->render();
    }
}