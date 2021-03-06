#!/usr/bin/env bash
set -e

# Install Magento with dependencies
echo "Create magento project"
cd /tmp
composer create-project --no-interaction --ignore-platform-reqs --repository-url=https://repo.magento.com/ ${MAGE2_VERSION} build
cd build

cp -vf ${TRAVIS_BUILD_DIR}/tests/setup/install-config-mysql.php dev/tests/integration/etc/

echo "Install magento"
php bin/magento setup:install --no-interaction \
    --admin-email "$MAGE2_ADMIN_EMAIL" \
    --admin-firstname "$MAGE2_ADMIN_FIRST_NAME" \
    --admin-lastname "$MAGE2_ADMIN_LAST_NAME" \
    --admin-password "$MAGE2_ADMIN_PASSWORD" \
    --admin-user "$MAGE2_ADMIN_USERNAME" \
    --backend-frontname admin \
    --base-url "$MAGE2_FAKE_URL" \
    --db-host "$MAGE2_DB_HOST" \
    --db-name "$MAGE2_DB_NAME" \
    --db-user "$MAGE2_DB_USER" \
    --db-password "$MAGE2_DB_PASSWORD" \
    --session-save files \
    --use-rewrites 1 \
    --use-secure 0 \
    -vvv