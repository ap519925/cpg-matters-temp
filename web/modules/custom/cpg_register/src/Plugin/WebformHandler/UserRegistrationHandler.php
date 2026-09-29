<?php

namespace Drupal\cpg_register\Plugin\WebformHandler;

use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface;

/**
 * Creates a user upon registration form submission.
 *
 * @WebformHandler(
 *   id = "user_registration",
 *   label = @Translation("User Registration"),
 *   category = @Translation("Action"),
 *   description = @Translation("Creates a user account on submission."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_SINGLE,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 * )
 */
class UserRegistrationHandler extends WebformHandlerBase {

  /**
   * {@inheritdoc}
   */
  public function postSave(WebformSubmissionInterface $webform_submission, $update = TRUE) {
    \Drupal::logger('cpg_register')->notice('DEBUG: Handler fired. update=@update', ['@update' => $update ? 'TRUE' : 'FALSE']);

    $data = $webform_submission->getData();
    \Drupal::logger('cpg_register')->notice('DEBUG: Data keys: @keys', ['@keys' => implode(', ', array_keys($data))]);

    $username = $data['username'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $display_name = $data['display_name'] ?? '';

    \Drupal::logger('cpg_register')->notice('DEBUG: username=@u, email=@e, password_empty=@p', [
      '@u' => $username,
      '@e' => $email,
      '@p' => empty($password) ? 'YES' : 'NO',
    ]);

    if (empty($username) || empty($email)) {
      \Drupal::logger('cpg_register')->warning('DEBUG: Exiting - username or email empty.');
      return;
    }

    $existing_user = user_load_by_name($username);
    $existing_email = user_load_by_mail($email);

    if ($existing_user || $existing_email) {
      \Drupal::logger('cpg_register')->warning('DEBUG: Exiting - user already exists. user=@u, email=@e', [
        '@u' => $existing_user ? 'EXISTS' : 'no',
        '@e' => $existing_email ? 'EXISTS' : 'no',
      ]);
      return;
    }

    try {
      $new_user = \Drupal\user\Entity\User::create();
      $new_user->setUsername($username);
      $new_user->setEmail($email);
      $new_user->setPassword($password);

      if ($new_user->hasField('field_display_name')) {
        $new_user->set('field_display_name', $display_name);
      }

      $new_user->activate();
      $new_user->enforceIsNew();
      $new_user->save();
      \Drupal::logger('cpg_register')->notice('DEBUG: User saved successfully. Sending mail...');

      _user_mail_notify('register_no_approval_required', clone $new_user);
      user_login_finalize($new_user);

      \Drupal::logger('cpg_register')->notice('New user registered via webform: @email', ['@email' => $email]);
    } catch (\Exception $e) {
      \Drupal::logger('cpg_register')->error('Registration via webform failed: @error', ['@error' => $e->getMessage()]);
    }
  }

}
