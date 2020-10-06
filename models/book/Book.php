<?php

namespace app\models\book;

use Intervention\Image\ImageManager;
use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

use app\models\User;
use yii\web\UploadedFile;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $phone
 * @property string $firstname
 * @property string|null $lastname
 * @property string|null $image
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $user
 */
class Book extends \yii\db\ActiveRecord
{
    const PATTERN_PHONE = '/^(8|7|\+7)?[\-\(]?([389][0-9]{2})[\-\)]?(\d{3})[\-]?(\d{2})[\-]?(\d{2})$/';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('UNIX_TIMESTAMP()'),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ActiveRecord::EVENT_BEFORE_DELETE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'phone' => 'Phone',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone'], 'unique'],
            [['phone', 'firstname'], 'required'],
            [['phone', 'firstname', 'lastname'], 'string', 'max' => 255],
            ['phone', 'match',
                'pattern' => self::PATTERN_PHONE,
                'message' => 'Телефона, должно быть в формате 8(XXX)XXX-XX-XX'
            ],
            ['image', 'image', 'extensions' => 'jpg, png', 'maxSize' => 1024 * 1024 * 2],
        ];
    }


    /**
     * @param UploadedFile $image
     */
    public function saveImage(UploadedFile $image): void
    {
        if (file_exists($image->tempName)) {
            $img = (new ImageManager)->make($image->tempName)
                ->fit(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });
            $img_name = md5($image->getBaseName() . '_' . time() . rand(10, 99)) . '.' . $image->extension;
            $save = $img->save(Yii::getAlias('@imagepath') . '/' . $img_name, 80);
            if ($save) {
                $this->setImage($img_name);
            }
        }
    }

    /**
     * @param string $phone
     * @return string|null
     */
    public function parsePhone(string $phone): ?string
    {
        $phone = preg_replace(self::PATTERN_PHONE, '$2$3$4$5', $phone);
        if ($phone) {
            return '+7' . $phone;
        }
        return null;
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setFirstName(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstname;
    }

    public function setLastName(string $lastname = null): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastname;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setImage(string $image = null): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getImageUrl(): ?string
    {
        return $this->getImage() ? Yii::getAlias('@imageurl') . '/' . $this->getImage() : null;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
}
