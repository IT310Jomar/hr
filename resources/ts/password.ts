import zxcvbn from 'zxcvbn';
import passwordGenerator from 'password-generator';

const password = ref('');
const indicatorClasses = ref('');

function checkPassword() {
  const strength = {
    0: 'Worst',
    1: 'Bad',
    2: 'Weak',
    3: 'Good',
    4: 'Strong',
  };
  const score = zxcvbn(password.value).score;
  indicatorClasses.value = `strength-${score}`;
}

function generatePassword() {
  password.value = passwordGenerator(12, false, /[\w\d\?\-]/);
  checkPassword();
}

export { password, indicatorClasses, checkPassword, generatePassword };
<style scoped>
.strength-0 {
  background-color: red;
}
.strength-1 {
  background-color: orange;
}
.strength-2 {
  background-color: yellow;
}
.strength-3 {
  background-color: lightgreen;
}
.strength-4 {
  background-color: green;
}
