<?php
namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;
use Helpers\DatabaseHelper;

class Cron extends AbstractCommand
{
    // TODO: エイリアスを設定してください。
    protected static ?string $alias = 'cron';

    // TODO: 引数を設定してください。
    public static function getArguments(): array
    {
        return [];
    }

    // TODO: 実行コードを記述してください。
    public function execute(): int
    {
        $deletionType = $this->getCommandValue();
        $this->log('Execute the deletion method provided via cron.' . $deletionType);

        if ($deletionType === 'soft') {
            $this->softDeletion();
        } else if ($deletionType === 'hard') {
            $this->hardDeletion();
        } 

        return 0;
    }

    private function softDeletion(){
        DatabaseHelper::softDeleteSnippet();
    }

    private function hardDeletion(){
        DatabaseHelper::hardDeleteSnippet();
    }
}