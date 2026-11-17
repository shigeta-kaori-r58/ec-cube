<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eccube\Entity;

use Doctrine\ORM\Mapping as ORM;

if (!class_exists(StockAlertSetting::class)) {
    /**
     * StockAlertSetting
     *
     * @ORM\Table(
     *     name="dtb_stock_alert_setting",
     *     indexes={
     *         @ORM\Index(name="dtb_stock_alert_setting_is_enabled_idx", columns={"is_enabled"}),
     *         @ORM\Index(name="dtb_stock_alert_setting_create_date_idx", columns={"create_date"})
     *     },
     *     uniqueConstraints={
     *         @ORM\UniqueConstraint(name="uk_stock_alert_product_class_id", columns={"product_class_id"})
     *     }
     * )
     *
     * @ORM\InheritanceType("SINGLE_TABLE")
     *
     * @ORM\DiscriminatorColumn(name="discriminator_type", type="string", length=255)
     *
     * @ORM\HasLifecycleCallbacks()
     *
     * @ORM\Entity(repositoryClass="Eccube\Repository\StockAlertSettingRepository")
     */
    class StockAlertSetting extends AbstractEntity
    {
        /**
         * @var int
         *
         * @ORM\Column(name="id", type="integer", options={"unsigned":true})
         *
         * @ORM\Id
         *
         * @ORM\GeneratedValue(strategy="IDENTITY")
         */
        private $id;

        /**
         * @var int
         *
         * @ORM\Column(name="threshold", type="integer", options={"unsigned":true, "default":0})
         */
        private $threshold = 0;

        /**
         * @var bool
         *
         * @ORM\Column(name="is_enabled", type="boolean", options={"default":true})
         */
        private $isEnabled = true;

        /**
         * @var string|null
         *
         * @ORM\Column(name="memo", type="text", nullable=true)
         */
        private $memo;

        /**
         * @var \DateTime
         *
         * @ORM\Column(name="create_date", type="datetimetz")
         */
        private $create_date;

        /**
         * @var \DateTime
         *
         * @ORM\Column(name="update_date", type="datetimetz")
         */
        private $update_date;

        /**
         * @var ProductClass
         *
         * @ORM\OneToOne(targetEntity="Eccube\Entity\ProductClass", inversedBy="StockAlertSetting")
         *
         * @ORM\JoinColumns({
         *
         *   @ORM\JoinColumn(name="product_class_id", referencedColumnName="id", onDelete="CASCADE")
         * })
         */
        private $ProductClass;

        /**
         * @var Member|null
         *
         * @ORM\ManyToOne(targetEntity="Eccube\Entity\Member")
         *
         * @ORM\JoinColumns({
         *
         *   @ORM\JoinColumn(name="creator_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
         * })
         */
        private $Creator;

        /**
         * Get id.
         *
         * @return int
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Set threshold.
         *
         * @param int $threshold
         *
         * @return StockAlertSetting
         */
        public function setThreshold($threshold)
        {
            $this->threshold = $threshold;

            return $this;
        }

        /**
         * Get threshold.
         *
         * @return int
         */
        public function getThreshold()
        {
            return $this->threshold;
        }

        /**
         * Set isEnabled.
         *
         * @param bool $isEnabled
         *
         * @return StockAlertSetting
         */
        public function setIsEnabled($isEnabled)
        {
            $this->isEnabled = $isEnabled;

            return $this;
        }

        /**
         * Get isEnabled.
         *
         * @return bool
         */
        public function isEnabled()
        {
            return $this->isEnabled;
        }

        /**
         * Set memo.
         *
         * @param string|null $memo
         *
         * @return StockAlertSetting
         */
        public function setMemo($memo = null)
        {
            $this->memo = $memo;

            return $this;
        }

        /**
         * Get memo.
         *
         * @return string|null
         */
        public function getMemo()
        {
            return $this->memo;
        }

        /**
         * Set createDate.
         *
         * @param \DateTime $createDate
         *
         * @return StockAlertSetting
         */
        public function setCreateDate($createDate)
        {
            $this->create_date = $createDate;

            return $this;
        }

        /**
         * Get createDate.
         *
         * @return \DateTime
         */
        public function getCreateDate()
        {
            return $this->create_date;
        }

        /**
         * Set updateDate.
         *
         * @param \DateTime $updateDate
         *
         * @return StockAlertSetting
         */
        public function setUpdateDate($updateDate)
        {
            $this->update_date = $updateDate;

            return $this;
        }

        /**
         * Get updateDate.
         *
         * @return \DateTime
         */
        public function getUpdateDate()
        {
            return $this->update_date;
        }

        /**
         * Set productClass.
         *
         * @param ProductClass|null $productClass
         *
         * @return StockAlertSetting
         */
        public function setProductClass(?ProductClass $productClass = null)
        {
            $this->ProductClass = $productClass;

            return $this;
        }

        /**
         * Get productClass.
         *
         * @return ProductClass|null
         */
        public function getProductClass()
        {
            return $this->ProductClass;
        }

        /**
         * Set creator.
         *
         * @param Member|null $creator
         *
         * @return StockAlertSetting
         */
        public function setCreator(?Member $creator = null)
        {
            $this->Creator = $creator;

            return $this;
        }

        /**
         * Get creator.
         *
         * @return Member|null
         */
        public function getCreator()
        {
            return $this->Creator;
        }
    }
}
