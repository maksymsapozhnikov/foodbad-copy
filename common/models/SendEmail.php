<?php

namespace common\models;

use Yii;


class SendEmail extends EmailTemplate
{
    protected $category_id;
    protected $sendTo = '';
    protected $setSubject = '';
    protected $content = '';

    /**
     * @param integer $request_id
     */
    public function sendSupportRequest($request_id)
    {
        try{
            $link = Yii::$app->params['backend_url'] . '/messages/view?id=' . $request_id;
            $this->category_id = self::CATEGORY_SUPPORT_REQUEST;
            $template = $this->getTemplate();
            $this->sendTo = Yii::$app->params['supportEmail'];
            $this->setSubject = $template->title;
            $this->content = str_replace('{{link}}', $link, $template['body']);
        }catch (\ErrorException $e){
            Yii::error('Error send Support Request', 'Email');
        }
        return $this->sendEmail();
    }

    public function sendRequestPasswordReset(User $user)
    {
        try{
            $link = Yii::$app->urlManager->createAbsoluteUrl(['/reset-password', 'token' => $user->password_reset_token]);
            $this->category_id = self::CATEGORY_REQUEST_PASSWORD_RESET;
            $template = $this->getTemplate();
            $this->sendTo = $user->email;
            $this->setSubject = $template->title;
            $this->content = str_replace(['{{link}}', '{{username}}'], [$link, $user->username], $template['body']);
        }catch (\ErrorException $e){
            Yii::error('Error send Request Password Reset', 'Email');
        }
        return $this->sendEmail();
    }

    public function sendSignUp(User $user){
        try{
            $this->category_id = self::CATEGORY_SIGN_UP;
            $template = $this->getTemplate();
            $this->sendTo = $user->email;
            $this->setSubject = $template->title;
            $this->content = str_replace(['{{username}}'], [$user->username], $template['body']);
        }catch (\ErrorException $e){
            Yii::error('Error send email after signUp', 'Email');
        }
        return $this->sendEmail();

    }

    protected function getTemplate()
    {
        return EmailTemplate::findOne(['id' => $this->category_id]);
    }

    /**
     * @return bool
     */
    protected function sendEmail()
    {
        return Yii::$app->mailer->compose('general_template', [
              'content' => $this->content
           ])->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
           ->setTo($this->sendTo)
           ->setSubject($this->setSubject)
           ->send();
    }


}