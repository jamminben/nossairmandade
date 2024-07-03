<?php
namespace App\Services;

use App\Models\Hinario;
use App\Models\HinarioSection;
use App\Models\HinarioSectionTranslation;
use App\Models\HinarioTranslation;

class HinarioService
{
    public function createHinario()
    {
        $hinario = new Hinario();



    }

    public function preloadHinario($hinarioId)
    {
        $hinarioModel = Hinario::where('id', $hinarioId)
            ->with('translations', 'sections', 'hymns', 'hymnHinarios', 'hymnHinarios.hinario', 'receivedBy', 'mediaFiles', 'hymns.mediaFiles', 'hymns.translations', 'hymns.hymnHinarios')
            ->first();

        $recordingSourceModels = $hinarioModel->getRecordingSources();

        $recordingSourceArray = [];
        foreach ($recordingSourceModels as $recordingSourceModel) {
            $recordingSourceArray[] = [
                'id' => $recordingSourceModel->id,
                'url' => $recordingSourceModel->url,
                'description' => $recordingSourceModel->description
            ];
        }
        $otherMediaModels = $hinarioModel->getOtherMedia();

        $otherMediaArray = [];
        foreach ($otherMediaModels as $otherMediaModel) {
            $otherMediaArray[] = [
                'url' => $otherMediaModel->url,
                'filename' => $otherMediaModel->filename,
                'source' => [
                    'url' => $otherMediaModel->source->url,
                    'description' => $otherMediaModel->source->getDescription()
                ]
            ];
        }

        $receivedByArray = [];
        if (!empty($hinarioModel->receivedBy)) {
            $receivedByModel = $hinarioModel->receivedBy;

            $receivedByArray = [
                'slug' => $receivedByModel->getSlug(),
                'display_name' => $receivedByModel->display_name
            ];
        }

        $hymnHinarioModels = $hinarioModel->hymnHinarios;

        $hymnHinarioArray = [];
        $hinarioHymnsArray = [];
        foreach ($hymnHinarioModels as $hymnHinarioModel) {
            $hymnModel = $hymnHinarioModel->hymn;

            $hymnArray = [];
            if (!empty($hymnModel)) {

                $hymnRecordingArray = [];
                foreach ($recordingSourceModels as $recordingSourceModel) {
                    if (!empty($hymnModel->getRecording($recordingSourceModel->id))) {
                        $hymnRecordingArray[$recordingSourceModel->id] = [
                            'url' => $hymnModel->getRecording($recordingSourceModel->id)->url,
                        ];
                    }
                }

                $hymnArray = [
                    'id' => $hymnModel->id,
                    'slug' => $hymnModel->getSlug(),
                    'name' => $hymnModel->getName($hymnModel->original_language_id),
                    'number' => $hymnModel->getNumber($hinarioModel->id),
                    'recordings' => $hymnRecordingArray
                ];
            }

            $hymnHinarioArray[] = [
                'list_order' => $hymnHinarioModel->list_order,
                'section' => $hymnHinarioModel->getSection()->getName(),
                'hymn' => $hymnArray,
            ];

            $hinarioHymnsArray[] = $hymnArray;
        }

        $hinarioArray = [
            'name' => $hinarioModel->getName($hinarioModel->original_language_id),
            'type_id' => $hinarioModel->type_id,
            'id' => $hinarioModel->id,
            'slug' => $hinarioModel->getSlug(),
            'recordingSources' => $recordingSourceArray,
            'receivedBy' => $receivedByArray,
            'hymnHinarios' => $hymnHinarioArray,
            'hymns' => $hinarioHymnsArray,
            'otherMedia' => $otherMediaArray,
            'displaySections' => $hinarioModel->displaySections()
        ];

        $hinarioJson = json_encode($hinarioArray);

        $hinarioModel->preloaded_json = $hinarioJson;
        $hinarioModel->save();
    }

    public function addSection($hinario, $sectionName, $secondaryLanguageId, $secondaryName)
    {
        $section = new HinarioSection();
        $section->hinario_id = $hinario->id;
        $section->section_number = count($hinario->getSections());
        $section->save();

        $sectionTranslation = new HinarioSectionTranslation();
        $sectionTranslation->hinario_section_id = $section->id;
        $sectionTranslation->language->id = $hinario->original_language_id;
        $sectionTranslation->name = $sectionName;
        $sectionTranslation->save();

        $sectionSecondaryTranslation = new HinarioSectionTranslation();
        $sectionSecondaryTranslation->hinario_section_id = $section->id;
        $sectionSecondaryTranslation->language->id = $secondaryLanguageId;
        $sectionSecondaryTranslation->name = $secondaryName;
        $sectionSecondaryTranslation->save();

        $hymnHinario = $hinario->hymnHinarios;

        $newHymnHinario = $this->hymnService->makeNewHymn($hinario, $hymnHinario);
    }
}
