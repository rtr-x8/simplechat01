<?php


namespace CountDownChat\Infrastructure\Message;


use CountDownChat\Domain\Deadline\Deadline;
use CountDownChat\Domain\Message\Message;
use LINE\LINEBot\Constant\Flex\BubleContainerSize;
use LINE\LINEBot\Constant\Flex\ComponentFontSize;
use LINE\LINEBot\Constant\Flex\ComponentFontWeight;
use LINE\LINEBot\Constant\Flex\ComponentLayout;
use LINE\LINEBot\Constant\Flex\ComponentSpacing;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\CarouselContainerBuilder;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;

class DeadlinesMessage implements Message
{
    /**
     * @var Deadline[]
     */
    private array $deadlines;

    /**
     * DeadlinesMessageBuilder constructor.
     * @param  array  $deadlines
     */
    public function __construct(array $deadlines)
    {
        $this->deadlines = $deadlines;
    }

    /**
     * @inheritDoc
     */
    public function get(): MessageBuilder
    {
        $bubbles = collect($this->deadlines)->map(function (Deadline $deadline) {
            return $this->createDeadlineBubble($deadline);
        })->toArray();
        return FlexMessageBuilder::builder()
            ->setAltText('カウントダウンのお知らせです！')
            ->setContents(new CarouselContainerBuilder($bubbles));
    }

    /**
     * @param  Deadline  $deadline
     * @return ContainerBuilder
     */
    private function createDeadlineBubble(Deadline $deadline): ContainerBuilder
    {
        return BubbleContainerBuilder::builder()
            ->setHeader($this->createDeadlineBubbleHeader($deadline))
            ->setSize(BubleContainerSize::KILO)
            ->setBody($this->createDeadlineBubbleBody($deadline));
    }

    private function createDeadlineBubbleHeader(Deadline $deadline)
    {
        $headerTextComponent = TextComponentBuilder::builder()
            ->setText($deadline->getName()->value())
            ->setSize(ComponentFontSize::MD)
            ->setWeight(ComponentFontWeight::BOLD)
            ->setWrap(true)
            ->setFlex(0);
        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setBackgroundColor('#27ACB2')
            ->setPaddingAll(ComponentSpacing::LG)
            ->setContents([$headerTextComponent]);
    }

    private function createDeadlineBubbleBody(Deadline $deadline)
    {
        $bodyText = CountDownMessageBuilder::new(today(), $deadline)->toString();
        $bodyTextComponent = TextComponentBuilder::builder()
            ->setText($bodyText)
            ->setSize(ComponentFontSize::MD)
            ->setWrap(true)
            ->setFlex(0);
        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setSpacing(ComponentSpacing::MD)
            ->setPaddingAll(ComponentSpacing::LG)
            ->setContents([$bodyTextComponent]);
    }
}
