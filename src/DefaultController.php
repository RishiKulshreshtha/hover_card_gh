<?php
namespace Drupal\hover_card;

/**
 * Default controller for the hover_card module.
 */
class DefaultController extends ControllerBase {

  public function hover_card(\Drupal\user\UserInterface $user = []) {
    $picture = [];
    $name = $mail = $roles = "";

    if (!$user->getUsername() && $user->getUsername()) {
      $name = $user->getUsername();
    }

    if (!$user->getEmail() && $user->getEmail() && \Drupal::config('hover_card.settings')->get('hover_card_user_email_display_status')) {
      $mail = $user->getEmail();
    }

    if (isset($user->picture->uri) && !empty($user->picture->uri)) {
      $picture_build = array(
        '#theme' => 'image_style',
        '#path' => $user->picture->uri,
        '#style_name' => 'thumbnail',
      );
      $picture = drupal_render($picture_build);
    }

    foreach ($user->roles as $value) {
      $roles = $value;
    }

    $user_data = [
      'name' => \Drupal\Component\Utility\SafeMarkup::checkPlain($name),
      'mail' => \Drupal\Component\Utility\SafeMarkup::checkPlain($mail),
      'picture' => $picture,
      'roles' => \Drupal\Component\Utility\SafeMarkup::checkPlain($roles),
    ];

    $hover_card_template_build = array(
      '#theme' => 'hover_card_template',
      '#details' => $user_data,
    );

    $hover_card_template = drupal_render($hover_card_template_build);

    return $hover_card_template;
  }

}
